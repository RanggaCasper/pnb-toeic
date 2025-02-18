<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.login');
    }
    
    /**
     * Handle an incoming authentication request.
     *
     * @param Request $request The HTTP request instance containing the 
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the 
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identity' => 'required',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                
                $user = Auth::user();
                $role = $user->role->name;
                
                return ResponseFormatter::redirected('Login successful!', route("{$role}.dashboard"));
            }
            return ResponseFormatter::error('Credentials not match our records.', code: 422);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);  
        }
    }
}
