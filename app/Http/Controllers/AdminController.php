<?php

namespace App\Http\Controllers;

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
        return view('admin.dashboard');
    }
}
