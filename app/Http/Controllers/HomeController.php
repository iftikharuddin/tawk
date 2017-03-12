<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Nahid\Talk\Live\Broadcast;

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
     * Show the list of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('home', compact('users'));
    }
     /*
    @ Random test playing with Pusher - by Team Aliens
    */
    public function tests()
    {

        $b = new Broadcast(\Illuminate\Contracts\Config\Repository::class, \Vinkla\Pusher\PusherFactory::class);
        dd($b->tests());
    }
}
