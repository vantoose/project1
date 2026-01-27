<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->authorizeResource(Post::class, 'post');
	}

  /**
   * Display a listing of the resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $user = $request->user();
    $posts = $user->posts()->ordered()
    ->search($request->input('q'))
    ->paginate(20)->withQueryString();
    return view('posts.index')->withPosts($posts);
  }

  public function published(Request $request)
  {
    $posts = POST::published()->ordered()
    ->search($request->input('q'))
    ->paginate(20)->withQueryString();
    return view('posts.published')->withPosts($posts);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('posts.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StorePost $request)
  {
    $validated = $request->validated();
    try {
      $post = new Post;
      $post->title = $validated['title'];
      $post->content = $validated['content'];
      $post->user_id = $request->user()->id;
      $post->save();
      return redirect()->route('posts.show', $post)->withStatus("Success.");
    } catch (\Exception $e) {
      $errors = $e->getMessage();
      return back()->withErrors($errors);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function show(Post $post)
  {
    return view('posts.show')->withPost($post);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function edit(Post $post)
  {
    return view('posts.edit')->withPost($post);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function update(UpdatePost $request, Post $post)
  {
    $validated = $request->validated();
    try {
      $post->title = $validated['title'];
      $post->content = $validated['content'];
			$post->published_at = $validated['is_published'] ?? 0 ? now() : null;
      $post->save();
      return redirect()->route('posts.show', $post)->withStatus("Success.");
    } catch (\Exception $e) {
      $errors = $e->getMessage();
      return back()->withErrors($errors);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function destroy(Post $post)
  {
    try {
      $post->delete();
      return redirect()->route('posts.index')->withStatus("Success.");
    } catch (\Exception $e) {
      $errors = $e->getMessage();
      return back()->withErrors($errors);
    }
  }
}
