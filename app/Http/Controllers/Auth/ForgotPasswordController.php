<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\TokenEmail;
use App\Models\EmailToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
                return ResponseFormatter::error('User not found.', Response::HTTP_NOT_FOUND);
            }

            if ($data->token !== $request->token) {
                return ResponseFormatter::error('Invalid token.', Response::HTTP_UNAUTHORIZED);
            }

            if ($data->expired_at < Carbon::now()) {
                $data->delete();
                return ResponseFormatter::error('Token expired.', Response::HTTP_UNAUTHORIZED);
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
