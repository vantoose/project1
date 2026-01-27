<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Upload;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
        return view('public.posts.index')->withPosts($posts);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function posts_show(Post $post)
    {
        $this->authorize('view', $post);
        return view('public.posts.show')->withPost($post);
    }

	/**
	 * Download the specified resource.
	 *
	 * @param  String  $hash
	 * @return \Illuminate\Http\Response
	 */

    public function uploads_download($hash)
    {
        $upload = Upload::findByHash($hash);
        if (!$upload) abort(404, 'Файл не найден');
        return $upload->download();
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
	    return view('hash')->with(['query' => $query, 'hash' => $hash]);
    }
}
