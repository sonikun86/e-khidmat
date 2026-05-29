<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pac;
use App\Models\Ranting;

class PengurusDashboardController extends Controller
{
    public function index()
    {
        $userPacName = Auth::user()->pac;
        $pac = Pac::where('nama_pac', $userPacName)->first();
        
        $stats = [
            'total_ranting' => 0,
            'makesta' => 0,
            'lakmud' => 0,
            'latin' => 0,
            'lakut' => 0,
            'laknas' => 0,
        ];

        if ($pac) {
            $rantings = Ranting::where('pac_id', $pac->id)->get();
            $stats['total_ranting'] = $rantings->count();
            $stats['makesta'] = $rantings->sum('makesta');
            $stats['lakmud'] = $rantings->sum('lakmud');
            $stats['latin'] = $rantings->sum('latin');
            $stats['lakut'] = $rantings->sum('lakut');
            $stats['laknas'] = $rantings->sum('laknas');
        }

        $suratMasukTerbaru = \App\Models\Surat::whereIn('penerima', [$userPacName, 'Semua PAC'])
            ->whereIn('status', ['terkirim'])
            ->latest()
            ->take(5)
            ->get();

        $dokumenTerbaru = \App\Models\DokumenSekretariat::latest()->take(5)->get();

        return view('pengurus.dashboard', compact('pac', 'stats', 'suratMasukTerbaru', 'dokumenTerbaru'));
    }
}
