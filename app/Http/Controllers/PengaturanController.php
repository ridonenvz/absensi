<?php

namespace App\Http\Controllers;

use App\Models\JamKerja;
use App\Models\UnitKerja;
use App\Models\User;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('pengaturan.index', [
            'totalUnitKerja' => UnitKerja::count(),
            'totalJamKerja' => JamKerja::count(),
            'totalUser' => User::count(),
        ]);
    }
}
