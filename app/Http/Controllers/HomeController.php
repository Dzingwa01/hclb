<?php

namespace App\Http\Controllers;

use App\Location;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $users = User::all();
        $user = Auth::user()->load('roles');
        $locations = Location::orderBy('location_name','asc')->get();
        if($user->roles[0]->name=='app-admin'){
            return view('admin-home',compact('users','locations'));
        }else{
            return view('home');
        }
    }
}
