<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // Menampilkan data mahasiswa
    public function mahasiswaIndex()
    {
        $mahasiswa = Mahasiswa::with('prodi')->get(); // Menampilkan semua mahasiswa dengan relasi prodi
        return response()->json($mahasiswa);
    }

    // Menampilkan data fakultas
    public function fakultasIndex()
    {
        $fakultas = Fakultas::all(); // Menampilkan semua fakultas
        return response()->json($fakultas);
    }

    // Menampilkan data prodi
    public function prodiIndex()
    {
        $prodi = Prodi::all(); // Menampilkan semua prodi
        return response()->json($prodi);
    }

    public function postsIndex()
    {
        $posts = Post::with('categories')->get();
        return response()->json($posts);
    }
}
