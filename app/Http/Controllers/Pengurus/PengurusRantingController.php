<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pac;
use App\Models\Ranting;

class PengurusRantingController extends Controller
{
    /**
     * Dapatkan instance PAC dari user yang sedang login.
     */
    private function getUserPac()
    {
        return Pac::where('nama_pac', Auth::user()->pac)->first();
    }

    public function index()
    {
        $pac = $this->getUserPac();
        
        if (!$pac) {
            return redirect()->route('pengurus.dashboard')->with('error', 'Data PAC Anda tidak ditemukan di sistem.');
        }

        $rantings = Ranting::where('pac_id', $pac->id)->get();
        return view('pengurus.ranting.index', compact('rantings', 'pac'));
    }

    public function create()
    {
        $pac = $this->getUserPac();
        if (!$pac) {
            return redirect()->route('pengurus.dashboard')->with('error', 'Data PAC Anda tidak ditemukan di sistem.');
        }

        return view('pengurus.ranting.create', compact('pac'));
    }

    public function store(Request $request)
    {
        $pac = $this->getUserPac();
        if (!$pac) {
            return redirect()->route('pengurus.dashboard')->with('error', 'Data PAC Anda tidak ditemukan di sistem.');
        }

        $request->validate([
            'nama_ranting' => 'required|string|max:255',
            'nama_ketua' => 'nullable|string|max:255',
            'masa_khidmat' => 'nullable|string|max:255',
            'makesta' => 'nullable|integer|min:0',
            'lakmud' => 'nullable|integer|min:0',
            'latin' => 'nullable|integer|min:0',
            'lakut' => 'nullable|integer|min:0',
            'laknas' => 'nullable|integer|min:0',
        ]);

        Ranting::create([
            'pac_id' => $pac->id,
            'nama_ranting' => $request->nama_ranting,
            'nama_ketua' => $request->nama_ketua,
            'masa_khidmat' => $request->masa_khidmat,
            'makesta' => $request->makesta ?? 0,
            'lakmud' => $request->lakmud ?? 0,
            'latin' => $request->latin ?? 0,
            'lakut' => $request->lakut ?? 0,
            'laknas' => $request->laknas ?? 0,
        ]);

        // Update jumlah ranting di tabel PAC
        $pac->update(['jumlah_ranting' => Ranting::where('pac_id', $pac->id)->count()]);

        return redirect()->route('pengurus.ranting.index')->with('success', 'Data Ranting berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pac = $this->getUserPac();
        $ranting = Ranting::where('pac_id', $pac->id)->findOrFail($id);

        return view('pengurus.ranting.edit', compact('ranting', 'pac'));
    }

    public function update(Request $request, $id)
    {
        $pac = $this->getUserPac();
        $ranting = Ranting::where('pac_id', $pac->id)->findOrFail($id);

        $request->validate([
            'nama_ranting' => 'required|string|max:255',
            'nama_ketua' => 'nullable|string|max:255',
            'masa_khidmat' => 'nullable|string|max:255',
            'makesta' => 'nullable|integer|min:0',
            'lakmud' => 'nullable|integer|min:0',
            'latin' => 'nullable|integer|min:0',
            'lakut' => 'nullable|integer|min:0',
            'laknas' => 'nullable|integer|min:0',
        ]);

        $ranting->update([
            'nama_ranting' => $request->nama_ranting,
            'nama_ketua' => $request->nama_ketua,
            'masa_khidmat' => $request->masa_khidmat,
            'makesta' => $request->makesta ?? 0,
            'lakmud' => $request->lakmud ?? 0,
            'latin' => $request->latin ?? 0,
            'lakut' => $request->lakut ?? 0,
            'laknas' => $request->laknas ?? 0,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Data Ranting berhasil diperbarui']);
        }
        return redirect()->route('pengurus.ranting.index')->with('success', 'Data Ranting berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pac = $this->getUserPac();
        $ranting = Ranting::where('pac_id', $pac->id)->findOrFail($id);
        
        $ranting->delete();

        // Update jumlah ranting di tabel PAC
        $pac->update(['jumlah_ranting' => Ranting::where('pac_id', $pac->id)->count()]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Data Ranting berhasil dihapus']);
        }
        return redirect()->route('pengurus.ranting.index')->with('success', 'Data Ranting berhasil dihapus.');
    }
}
