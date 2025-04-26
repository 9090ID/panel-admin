<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Imports\MahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Exports\MahasiswaExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Mengambil data pengumuman dengan relasi kategori
            $data = Mahasiswa::with('prodi')->get();
            return datatables()->of($data)
                ->addIndexColumn()
                // ->addColumn('prodi', function ($row) {
                //     // Menggabungkan nama kategori, dengan pengecekan jika tidak ada kategori
                //     return $row->prodi->isEmpty() ? 'No CData' : $row->prodi->pluck('namaprodi')->implode(', ');
                // })
                // ->addColumn('tanggalpublish', function ($row) {
                //     // Mengubah format tanggalpublish ke format Indonesia
                //     return Carbon::parse($row->tanggalpublish)->isoFormat('D MMMM YYYY'); // Format Indonesia (contoh: 1 Januari 2025)
                // })
                ->addColumn('action', function ($row) {
                    return '
                            <a href="' . route('mhs.show', $row->id) . '" class="btn btn-info edit-btn"><i class="fas fa-edit"></i> Detail</a></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    //     $data = ['nama' => 'Mahasiswa', 'nim' => '12345'];
    // Log::info('Data mahasiswa:', $data);
    // return response()->json($data);
        return view('mahasiswa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodi = Prodi::all(); // Ambil semua data Prodi
        return view('mahasiswa.create', compact('prodi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:15|unique:mahasiswa,nim',
            'prodi_id' => 'required|exists:prodi,id',
            'angkatan' => 'required|integer|min:2000|max:' . date('Y'),
            'email' => 'nullable|email|max:255|unique:mahasiswa,email',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi file foto
        ]);

        $filePath = null;
        if ($request->hasFile('foto')) {
            $filePath = $request->file('foto')->store('foto_mahasiswa', 'public'); // Simpan di public/foto_mahasiswa
        }

        Mahasiswa::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'prodi_id' => $request->prodi_id,
            'angkatan' => $request->angkatan,
            'email' => $request->email,
            'foto' => $filePath,
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $prodi = Prodi::all(); // Ambil semua data Prodi
        return view('mahasiswa.edit', compact('mahasiswa', 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:15|unique:mahasiswa,nim,' . $mahasiswa->id,
            'prodi_id' => 'required|exists:prodi,id',
            'angkatan' => 'required|integer|min:2000|max:' . date('Y'),
            'email' => 'nullable|email|max:255|unique:mahasiswa,email,' . $mahasiswa->id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $filePath = $mahasiswa->foto; // Gunakan foto lama jika tidak diupload ulang
        if ($request->hasFile('foto')) {
            // Hapus file lama jika ada
            if ($filePath && Storage::exists('public/' . $filePath)) {
                Storage::delete('public/' . $filePath);
            }
            $filePath = $request->file('foto')->store('foto_mahasiswa', 'public');
        }

        $mahasiswa->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'prodi_id' => $request->prodi_id,
            'angkatan' => $request->angkatan,
            'email' => $request->email,
            'foto' => $filePath,
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        if ($mahasiswa->foto && Storage::exists('public/' . $mahasiswa->foto)) {
            Storage::delete('public/' . $mahasiswa->foto); // Hapus foto dari penyimpanan
        }

        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');

        try {
            DB::beginTransaction();

            Excel::import(new MahasiswaImport, $file);

            DB::commit();
            return response()->json(['message' => 'Data berhasil diimpor'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal mengimpor data: ' . $e->getMessage()], 400);
        }
    }
}
