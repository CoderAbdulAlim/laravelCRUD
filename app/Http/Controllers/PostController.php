<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only('store');
    }

    public function index()
    {
        // $posts = Post::orderBy('created_at', 'desc')->paginate(2);
        $posts = Post::with('user')->orderByDesc('id')->paginate(10);
        // $posts = Post::latest()->paginate(10);

        return view('posts.index',[
            'posts' => $posts
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        // $post = Post::create([
        //     // 'user_id' => auth()->id(),
        //     // 'user_id' => auth()->user()->id,
        //     'user_id' => $request->user()->id,
        //     'title' => $request->title,
        //     'body' => $request->body,
        // ]);

        // $post = $request->user()->posts()->create([
        //     'title' => $request->title,
        //     'body' => $request->body,
        // ]);

        $request->user()->posts()->create($request->only('title', 'body'));

        // dd($post);

        return back();
    }

    public function destroy(Post $post)
    {
        // if(!$post->ownerBy(auth()->user())){
        //     // return response(null, status:401);
        //     throw new AuthenticationException();
        // }

        // $this->authorize('delete-post', $post);
        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }
}
