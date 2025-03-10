<?php

namespace App\Http\Controllers\User\Token;

use App\Models\Token;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
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

    public function getByToken($token): JsonResponse
    {
        try {
            $data = Token::where('token',$token)->firstOrFail();
            return ResponseFormatter::success('Data successfully retrieved.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    } 
}
