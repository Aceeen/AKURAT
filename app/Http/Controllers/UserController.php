<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
     public function index()
    {
        // Hanya Kadin yang bisa melihat master data semua pegawai
        if (auth()->user()->role !== 'kadis') {
            abort(403);
        }

        $pegawai = User::with('unitKerja')->orderBy('nama', 'asc')->get();
        return view('pegawai.index', compact('pegawai'));
    }
}
