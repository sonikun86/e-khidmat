<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest('tanggal')->get();
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.post.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('posts', 'public');
        }

        Post::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $gambarPath,
            'penulis' => Auth::user()->nama_lengkap,
            'tanggal' => now(),
        ]);

        return redirect()->route('admin.post.index')->with('success', 'Berita berhasil diterbitkan.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.post.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('gambar')) {
            if ($post->gambar && Storage::disk('public')->exists($post->gambar)) {
                Storage::disk('public')->delete($post->gambar);
            }
            $post->gambar = $request->file('gambar')->store('posts', 'public');
        }

        $post->judul = $request->judul;
        $post->isi = $request->isi;
        $post->save();

        return redirect()->route('admin.post.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        if ($post->gambar && Storage::disk('public')->exists($post->gambar)) {
            Storage::disk('public')->delete($post->gambar);
        }

        $post->delete();

        return redirect()->route('admin.post.index')->with('success', 'Berita berhasil dihapus.');
    }
}
