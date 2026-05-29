<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokumenSekretariat;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumens = DokumenSekretariat::latest()->get();
        return view('pengurus.dokumen.index', compact('dokumens'));
    }
}
