<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::published()->ordered()->limit(5)->get();
        return view('home')->withPosts($posts);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function posts_index(Request $request)
    {
        $posts = Post::published()->ordered()
        ->search($request->input('q'))
        ->paginate(20)->withQueryString();
        return view('homes.posts.index')->withPosts($posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function posts_show(Post $post)
    {
        return view('homes.posts.show')->withPost($post);
    }

    /**
     * Show hash.
     *
	 * @param  \Illuminate\Http\Request  $request
     * @return 
     */
    public function hash(Request $request)
    {
        $query = $request->q ?: \Illuminate\Support\Str::random(8);
        $hash = \Illuminate\Support\Facades\Hash::make($query);
	    return view('homes.hash')->with(['query' => $query, 'hash' => $hash]);
    }

    /**
     * Show 5bukv.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bukv5()
    {
        return view('homes.bukv5');
    }
}
