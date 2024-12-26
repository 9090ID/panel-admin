<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TamuController extends Controller
{

    public function __construct()
    {
        // Memastikan hanya pengguna yang sudah login yang dapat mengakses controller ini
        $this->middleware('auth');

        // Memastikan hanya pengguna dengan role 'admin' yang bisa mengakses metode ini
        $this->middleware('role:user');
    }
    public function index()
    {
        return view('test');
    }
}
