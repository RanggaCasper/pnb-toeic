<?php

namespace App\Http\Controllers\User\Practice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    public function index()
    {
        return view('user.practice.index');
    }
}
