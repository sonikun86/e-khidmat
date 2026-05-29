<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::where('role', 'pengurus_pac')->orderBy('status', 'asc')->get();
        return view('admin.pengurus.index', compact('users'));
    }

    public function approve($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->status = 1; // 1 = Aktif
        $user->save();
        return back()->with('success', 'Akun pengurus berhasil disetujui.');
    }

    public function update(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'pac' => 'required|string|max:255',
            'status' => 'required|in:aktif,pending,1,0',
        ]);

        $status = $request->status;
        if ($status === 'aktif' || $status == '1') $status = 1;
        if ($status === 'pending' || $status == '0') $status = 0;
        
        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'pac' => $request->pac,
            'status' => $status
        ]);
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Data berhasil diupdate']);
        }
        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Akun berhasil dihapus']);
        }
        return back()->with('success', 'Akun pengurus berhasil dihapus.');
    }
}
