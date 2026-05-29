<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\Pac;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    // === SURAT MASUK ===
    public function masuk()
    {
        // Surat yang ditujukan ke admin dari PAC (status terkirim atau diarsipkan)
        $surats = Surat::where('penerima', 'Admin')
            ->whereIn('status', ['terkirim'])
            ->latest()->get();
        return view('admin.surat.masuk', compact('surats'));
    }

    // === SURAT KELUAR ===
    public function keluar()
    {
        // Surat yang dibuat oleh admin
        $surats = Surat::where('pengirim', 'Admin')
            ->whereIn('status', ['draft', 'terkirim'])
            ->latest()->get();
        return view('admin.surat.keluar', compact('surats'));
    }

    public function create()
    {
        $pacs = Pac::all();
        return view('admin.surat.create', compact('pacs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'file_surat' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:10240',
        ]);

        $filePath = $request->file('file_surat')->store('surat', 'public');

        Surat::create([
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'pengirim' => 'Admin',
            'penerima' => $request->penerima,
            'file_surat' => $filePath,
            'tipe_surat' => 'keluar', // Dari sisi admin ini surat keluar
            'status' => 'draft', // Selalu draft saat awal dibuat
        ]);

        return redirect()->route('admin.surat.keluar')->with('success', 'Draft surat berhasil dibuat. Silakan tinjau dan kirim.');
    }

    public function edit($id)
    {
        $surat = Surat::where('pengirim', 'Admin')->where('status', 'draft')->findOrFail($id);
        $pacs = Pac::all();
        return view('admin.surat.edit', compact('surat', 'pacs'));
    }

    public function update(Request $request, $id)
    {
        $surat = Surat::where('pengirim', 'Admin')->where('status', 'draft')->findOrFail($id);

        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:10240',
        ]);

        if ($request->hasFile('file_surat')) {
            if (Storage::disk('public')->exists($surat->file_surat)) {
                Storage::disk('public')->delete($surat->file_surat);
            }
            $surat->file_surat = $request->file('file_surat')->store('surat', 'public');
        }

        $surat->update([
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'penerima' => $request->penerima,
        ]);

        return redirect()->route('admin.surat.keluar')->with('success', 'Draft surat berhasil diperbarui.');
    }

    public function kirim($id)
    {
        $surat = Surat::where('pengirim', 'Admin')->findOrFail($id);
        $surat->update([
            'status' => 'terkirim',
            'tgl_kirim' => now()
        ]);

        return redirect()->route('admin.surat.keluar')->with('success', 'Surat berhasil dikirim ke tujuan.');
    }

    // === ARSIP ===
    public function arsipIndex()
    {
        // Semua surat admin (masuk/keluar) yang diarsipkan
        $surats = Surat::where(function($query) {
                $query->where('pengirim', 'Admin')->orWhere('penerima', 'Admin');
            })
            ->where('status', 'diarsipkan')
            ->latest()->get();
        return view('admin.surat.arsip', compact('surats'));
    }

    public function arsipkan($id)
    {
        $surat = Surat::findOrFail($id);
        
        // Cek apakah admin berhak
        if ($surat->pengirim !== 'Admin' && $surat->penerima !== 'Admin') {
            abort(403);
        }

        $surat->update(['status' => 'diarsipkan']);

        return back()->with('success', 'Surat berhasil diarsipkan.');
    }

    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);
        
        if ($surat->pengirim !== 'Admin' && $surat->penerima !== 'Admin') {
            abort(403);
        }

        if (Storage::disk('public')->exists($surat->file_surat)) {
            Storage::disk('public')->delete($surat->file_surat);
        }

        $surat->delete();

        return back()->with('success', 'Surat berhasil dihapus permanen.');
    }
}
