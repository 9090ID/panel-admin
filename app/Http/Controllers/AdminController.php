<?php

namespace App\Http\Controllers;
use App\Models\Pegawai;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // Memastikan hanya pengguna yang sudah login yang dapat mengakses controller ini
        $this->middleware('auth');

        // Memastikan hanya pengguna dengan role 'admin' yang bisa mengakses metode ini
        // $this->middleware('role:admin');
    }
    public function index()
    {
        $count_peg = Pegawai::count();
        $count_pengu = Pengumuman::count();
        $count_post = Post::count();
        $count_faku = Fakultas::count();
        $count_prod = Prodi::count();
        $count_mhs = Mahasiswa::count();
        return view('admin.dashboard',compact('count_peg','count_pengu','count_post','count_faku','count_prod','count_mhs'));
    }
}
