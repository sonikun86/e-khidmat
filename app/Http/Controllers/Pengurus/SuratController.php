<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\Pac;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    private function getUserPacName()
    {
        return Auth::user()->pac;
    }

    // === SURAT MASUK ===
    public function masuk()
    {
        $pac = $this->getUserPacName();
        // Surat untuk PAC ini atau Semua PAC (dari admin atau PAC lain)
        $surats = Surat::whereIn('penerima', [$pac, 'Semua PAC'])
            ->whereIn('status', ['terkirim'])
            ->latest()->get();
        return view('pengurus.surat.masuk', compact('surats'));
    }

    // === SURAT KELUAR ===
    public function keluar()
    {
        $pac = $this->getUserPacName();
        // Surat dari PAC ini untuk admin
        $surats = Surat::where('pengirim', $pac)
            ->whereIn('status', ['draft', 'terkirim'])
            ->latest()->get();
        return view('pengurus.surat.keluar', compact('surats'));
    }

    public function create()
    {
        $pac = $this->getUserPacName();
        $pacs = Pac::where('nama_pac', '!=', $pac)->get();
        return view('pengurus.surat.create', compact('pacs'));
    }

    public function store(Request $request)
    {
        $pac = $this->getUserPacName();
        
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
            'pengirim' => $pac,
            'penerima' => $request->penerima,
            'file_surat' => $filePath,
            'tipe_surat' => 'keluar',
            'status' => 'draft',
        ]);

        return redirect()->route('pengurus.surat.keluar')->with('success', 'Draft surat berhasil dibuat. Silakan tinjau dan kirim.');
    }

    public function edit($id)
    {
        $pac = $this->getUserPacName();
        $surat = Surat::where('pengirim', $pac)->where('status', 'draft')->findOrFail($id);
        $pacs = Pac::where('nama_pac', '!=', $pac)->get();
        return view('pengurus.surat.edit', compact('surat', 'pacs'));
    }

    public function update(Request $request, $id)
    {
        $pac = $this->getUserPacName();
        $surat = Surat::where('pengirim', $pac)->where('status', 'draft')->findOrFail($id);

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

        return redirect()->route('pengurus.surat.keluar')->with('success', 'Draft surat berhasil diperbarui.');
    }

    public function kirim($id)
    {
        $pac = $this->getUserPacName();
        $surat = Surat::where('pengirim', $pac)->findOrFail($id);
        
        $surat->update([
            'status' => 'terkirim',
            'tgl_kirim' => now()
        ]);

        return redirect()->route('pengurus.surat.keluar')->with('success', 'Surat berhasil dikirim ke tujuan.');
    }

    // === ARSIP ===
    public function arsipIndex()
    {
        $pac = $this->getUserPacName();
        $surats = Surat::where(function($query) use ($pac) {
                $query->where('pengirim', $pac)->orWhereIn('penerima', [$pac, 'Semua PAC']);
            })
            ->where('status', 'diarsipkan')
            ->latest()->get();
        return view('pengurus.surat.arsip', compact('surats'));
    }

    public function arsipkan($id)
    {
        $pac = $this->getUserPacName();
        $surat = Surat::findOrFail($id);
        
        // Verifikasi hak akses
        if ($surat->pengirim !== $pac && $surat->penerima !== $pac && $surat->penerima !== 'Semua PAC') {
            abort(403);
        }

        $surat->update(['status' => 'diarsipkan']);

        return back()->with('success', 'Surat berhasil diarsipkan.');
    }

    public function destroy($id)
    {
        $pac = $this->getUserPacName();
        $surat = Surat::where('pengirim', $pac)->where('status', 'draft')->findOrFail($id);
        
        if (Storage::disk('public')->exists($surat->file_surat)) {
            Storage::disk('public')->delete($surat->file_surat);
        }

        $surat->delete();

        return back()->with('success', 'Draft surat berhasil dihapus.');
    }
}
