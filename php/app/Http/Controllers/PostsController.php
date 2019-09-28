<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Post;
use Log;

class PostsController extends Controller
{
    public function index(Request $request)
    {

        logger("connect to server");



        if (!empty($request)) {
            $posts = Post::leftJoin('comments', 'posts.id', '=', 'comments.post_id')
                ->where('posts.title', 'like', "%{$request->word}%")->orWhere('comments.body', 'like', "%{$request->word}%")
                ->orWhere('posts.body', 'like', "%{$request->word}%")
                ->select('posts.id', 'posts.title', 'posts.body', 'posts.created_at')->paginate(3);
            return view('posts.index', ['posts' => $posts, 'word' => $request->word]);
        } else {
            $posts = Post::with(['comments'])->orderBy('created_at', 'desc')->paginate(10);
            return view('posts.index', ['posts' => $posts, 'word' => ""]);
        }
    }
    public function create()
    {
        return view('posts.create');
    }

    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function edit($post_id)
    {
        $post = Post::findOrFail($post_id);

        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update($post_id, Request $request)
    {
        $params = $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:2000',
        ]);
        Log::debug($request);

        $post = Post::findOrFail($post_id);
        $post->fill($params)->save();

        return redirect()->route('posts.show', ['post' => $post]);
    }

    public function destroy($post_id)
    {
        $post = Post::findOrFail($post_id);

        \DB::transaction(function () use ($post) {
            $post->comments()->delete();
            $post->delete();
        });

        return redirect()->route('top');
    }

    public function store(Request $request)
    {
        $params = $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|max:2000'
        ]);

        Post::create($params);

        return redirect()->route('top');
    }
}
