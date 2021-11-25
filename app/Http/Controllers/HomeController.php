<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

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
        $data = Message::where('id_pengirim',auth()->user()->id)
                ->orWhere('id_penerima',auth()->user()->id)->get();

        //dd($data);

        $users = User::where('id', '!=', auth()->user()->id)->get();
        //dd($users);
        return view('home',compact("users"));
    }
}
