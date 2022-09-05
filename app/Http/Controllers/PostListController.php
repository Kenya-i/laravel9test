<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostListController extends Controller
{
    public function index()
    {
        $posts = Post::query()
                ->with('user')
                ->withCount('comments')
                ->orderByDesc('comments_count')
                ->get();

        return view('index', compact('posts'));
    }
}
