<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Mahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TamuController extends Controller
{

    // public function __construct()
    // {
    //     // Memastikan hanya pengguna yang sudah login yang dapat mengakses controller ini
    //     $this->middleware('auth');
    // }
    public function index()
    {
        return view('user.dashboard');
    }

    public function myProfile()
    {

        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
    //    
        if ($mahasiswa) {
            // Eager load the prodi and fakultas relationships
            $mahasiswa->load('prodi.fakultas');
        }
        return view('user.profile', compact('user', 'mahasiswa'));
    }
    public function editMyprofil($id)
    {
        // Ambil data mahasiswa berdasarkan ID
        $mahasiswa = Mahasiswa::findOrFail($id);

        // Pastikan mahasiswa yang diambil adalah milik user yang sedang login
        if ($mahasiswa->user_id !== Auth::id()) {
            return redirect()->route('mhs.index')->with('error', 'Unauthorized access.');
        }
        if ($mahasiswa) {
            // Eager load the prodi and fakultas relationships
            $mahasiswa->load('prodi.fakultas');
        }

        return view('user.editMyprofil', compact('mahasiswa'));
    }
    
}
