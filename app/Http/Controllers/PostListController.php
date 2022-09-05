<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostListController extends Controller
{
    public function index()
    {
        $posts = Post::withCount('comments')->get();

        return view('index', compact('posts'));
    }
}
