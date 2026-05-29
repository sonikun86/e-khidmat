<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokumenSekretariat;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumens = DokumenSekretariat::latest()->get();
        return view('admin.dokumen.index', compact('dokumens'));
    }

    public function create()
    {
        return view('admin.dokumen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240', // max 10MB
        ]);

        $filePath = $request->file('file_dokumen')->store('dokumen', 'public');

        DokumenSekretariat::create([
            'nama_dokumen' => $request->nama_dokumen,
            'file_path' => $filePath,
        ]);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function destroy($id)
    {
        $dokumen = DokumenSekretariat::findOrFail($id);
        
        // Hapus file fisik
        if (Storage::disk('public')->exists($dokumen->file_path)) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
