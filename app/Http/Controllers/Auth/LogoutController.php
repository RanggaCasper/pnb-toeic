<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Logout the authenticated user.
     *
     * @param Request $request The HTTP request instance.
     * @return \Illuminate\Http\RedirectResponse Redirects to the login route with a success message.
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return ResponseFormatter::redirected('Logout successful, you will be redirected to login page.', route('login'));
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

}
