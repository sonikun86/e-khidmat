<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pac;
use App\Models\Ranting;
use App\Models\User;
use App\Models\Surat;
use App\Models\Post;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalPac = Pac::count();
        $totalRanting = Ranting::count();
        
        $totalKader = Ranting::sum('makesta') + 
                      Ranting::sum('lakmud') + 
                      Ranting::sum('latin') + 
                      Ranting::sum('lakut') + 
                      Ranting::sum('laknas');
                      
        $pendingPengurus = User::where('role', 'pengurus_pac')->where('status', 'pending')->count();
        
        $totalBerita = Post::count();
        
        $suratMasukTerbaru = Surat::where('penerima', 'Admin')
            ->whereIn('status', ['terkirim'])
            ->latest()
            ->take(5)
            ->get();
            
        // Data untuk Grafik
        $pacKaderData = \Illuminate\Support\Facades\DB::table('pacs')
            ->leftJoin('rantings', 'pacs.id', '=', 'rantings.pac_id')
            ->select('pacs.nama_pac', \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(rantings.makesta + rantings.lakmud + rantings.latin + rantings.lakut + rantings.laknas), 0) as total_kader'))
            ->groupBy('pacs.id', 'pacs.nama_pac')
            ->orderBy('total_kader', 'desc')
            ->take(10) // Tampilkan top 10
            ->get();

        $chartLabels = $pacKaderData->pluck('nama_pac');
        $chartData = $pacKaderData->pluck('total_kader');

        return view('admin.dashboard', compact(
            'totalPac',
            'totalRanting',
            'totalKader',
            'pendingPengurus',
            'totalBerita',
            'suratMasukTerbaru',
            'chartLabels',
            'chartData'
        ));
    }
}
