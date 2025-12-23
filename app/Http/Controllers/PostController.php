<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id'
        ]);

        $post = Post::create($data);

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

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $post->id,
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id'
        ]);

        $post->update($data);

        return response()->json([
            'status' => 'updated',
            'data' => $post
        ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'status' => 'deleted'
        ], 204);
    }
}
