<?php

namespace App\Http\Controllers\User\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        return view('user.about.index');
    }
    public function more()
    {
        return view('user.about.more');
    }
}
