<?php

namespace App\Http\Controllers;

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
        return view('home');
    }

    /**
     * Show hash.
     *
	 * @param  \Illuminate\Http\Request  $request
     * @return 
     */
    public function hash(Request $request)
    {
        $text = $request->q ?: \Illuminate\Support\Str::random(8);
        $hash = \Illuminate\Support\Facades\Hash::make($text);
        return ['text' => $text, 'hash' => $hash];
    }

    /**
     * Show 5bukv.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bukv5()
    {
        return view('bukv5');
    }
}
