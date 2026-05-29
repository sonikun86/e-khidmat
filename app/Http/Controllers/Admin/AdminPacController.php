<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPacController extends Controller
{
    public function index()
    {
        $pacs = \App\Models\Pac::orderBy('nama_pac', 'asc')->get();
        return view('admin.pac.index', compact('pacs'));
    }

    public function export()
    {
        $pacs = \Illuminate\Support\Facades\DB::table('pacs')
            ->leftJoin('rantings', 'pacs.id', '=', 'rantings.pac_id')
            ->select('pacs.nama_pac', 'pacs.ketua_pac', 'pacs.masa_khidmat', \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(rantings.makesta + rantings.lakmud + rantings.latin + rantings.lakut + rantings.laknas), 0) as total_kader'))
            ->groupBy('pacs.id', 'pacs.nama_pac', 'pacs.ketua_pac', 'pacs.masa_khidmat')
            ->orderBy('pacs.nama_pac', 'asc')
            ->get();

        $filename = "Data_PAC_Kader_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        // Add BOM to fix UTF-8 in Excel
        fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
        
        fputcsv($handle, ['No', 'Nama PAC', 'Ketua', 'Masa Khidmat', 'Total Kader']);
        
        $row = 1;
        foreach ($pacs as $pac) {
            fputcsv($handle, [$row++, $pac->nama_pac, $pac->ketua_pac ?? '-', $pac->masa_khidmat ?? '-', $pac->total_kader]);
        }
        
        fclose($handle);
        
        return response()->stream(function() {}, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pac' => 'required|string|max:255',
            'ketua_pac' => 'nullable|string|max:255',
            'masa_khidmat' => 'nullable|string|max:255',
        ]);
        
        $pac = new \App\Models\Pac();
        $pac->nama_pac = $request->nama_pac;
        $pac->ketua_pac = $request->ketua_pac;
        $pac->masa_khidmat = $request->masa_khidmat;
        $pac->save();
        
        return back()->with('success', 'PAC berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pac' => 'required|string|max:255',
            'ketua_pac' => 'nullable|string|max:255',
            'masa_khidmat' => 'nullable|string|max:255',
        ]);

        $pac = \App\Models\Pac::findOrFail($id);
        $pac->nama_pac = $request->nama_pac;
        $pac->ketua_pac = $request->ketua_pac;
        $pac->masa_khidmat = $request->masa_khidmat;
        $pac->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Data PAC berhasil diperbarui']);
        }
        return back()->with('success', 'Data PAC berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pac = \App\Models\Pac::findOrFail($id);
        $pac->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'PAC berhasil dihapus']);
        }
        return back()->with('success', 'PAC berhasil dihapus.');
    }
}
