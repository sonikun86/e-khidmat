<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class LandingController extends Controller
{
    public function index()
    {
        $posts = Post::latest('tanggal')->take(6)->get();
        return view('welcome', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('berita.show', compact('post'));
    }
}
