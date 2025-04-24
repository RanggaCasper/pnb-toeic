<?php

namespace App\Http\Controllers\User\Token;

use App\Models\Token;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class TokenController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            (new \Illuminate\Routing\Controllers\Middleware('checkAjax'))->except(['index']),
        ];
    }

    public function index()
    {
        return view('user.token.index');
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required'
        ]);
        
        try {
            $data = Token::where('token', $request->token)->firstOrFail();
            session(['token_data' => $data]);
            return ResponseFormatter::redirected('Token verifed successfully.', route('user.exam.index'));
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }
}
