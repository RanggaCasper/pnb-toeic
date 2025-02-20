<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\TokenEmail;
use App\Models\EmailToken;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ]);
        
        try {
            $data = EmailToken::where('email', $request->email)->first();

            if (!$data) {
                return ResponseFormatter::error('User not found.', 404);
            }

            if ($data->token !== $request->token) {
                return ResponseFormatter::error('Invalid token.', 422);
            }

            if ($data->expired_at < Carbon::now()) {
                $data->delete();
                return ResponseFormatter::error('Token expired.', 422);
            }

            $user = User::where('email', $request->email)->first();
            $user->password = bcrypt($request->password);
            $user->save();
            $data->delete();
            return ResponseFormatter::redirected('Password successfully updated.', route('login'));
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            $data = EmailToken::updateOrCreate(
                ['email' => $request->email],
                [
                    'token' => (new EmailToken())->generateToken(8),
                    'expired_at' => now()->addMinutes(180),
                ]
            );
            Mail::to($request->email)->send(new TokenEmail($data));
            return ResponseFormatter::success('Successfully sent token.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
