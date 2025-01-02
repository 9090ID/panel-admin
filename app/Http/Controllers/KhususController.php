<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\File;
use App\Models\Prodi;
class KhususController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Hapus semua mahasiswa yang terdaftar
            Mahasiswa::query()->delete();

            // Hapus semua prodi terkait (jika perlu, hanya jika prodi tidak digunakan di tempat lain)
            // Prodi::query()->delete(); // Hati-hati dengan penghapusan prodi

            // Commit transaksi jika tidak ada kesalahan
            DB::commit();

            return response()->json([
                'message' => 'Semua data mahasiswa dan prodi berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            // Rollback jika ada kesalahan
            DB::rollBack();

            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data.'
            ], 500);
        }
    }
    public function downloadFormat()
    {
         // Lokasi file di folder public/uploads
         $filePath = public_path('uploads/template_import_mahasiswa.xls');

         // Periksa apakah file ada
         if (!File::exists($filePath)) {
             abort(404, 'File template tidak ditemukan.');
         }
 
         // Unduh file
         return response()->download($filePath, 'template_import_mahasiswa.xls');
    }
    
}
