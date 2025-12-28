<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'author']);

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->sort === 'latest') {
            $query->latest();
        } elseif ($request->sort === 'oldest') {
            $query->oldest();
        }

        $posts = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = Post::create($request->validated());
        return response()->json([
            'status' => 'created',
            'data' => $post
        ], 201);
    }

    public function show(Post $post)
    {
        return response()->json([

            'status' => 'success',
            'data' => $post->load(['category', 'author', 'comments'])
        ]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $data = $request->validated();
        $post->update($data);
        return response()->json([
            'status' => 'updated', 'data' => $post]);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'status' => 'deleted'
        ], 204);
    }
}
