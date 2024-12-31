<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $user = Auth::user();
        // echo '<pre>';
        // print_r($user->role_id);
        // echo '</pre>';
        // dd($user);
        if ($user->role_id == 1) {
            return view('admin.dashboard');
        } elseif ($user->role_id == 2) {
            return view('employee.dashboard');
        }

        return view('dashboard');
    }


}