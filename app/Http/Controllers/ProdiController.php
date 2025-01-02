<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\Fakultas;
use App\Models\Pegawai;
use Yajra\DataTables\Facades\DataTables;

class ProdiController extends Controller
{
    public function index(Request $request)
    {
        $prodi = Prodi::with(['fakultas', 'pegawai'])->get();  // Pastikan memuat relasi 'fakultas' dan 'pegawai'

    if ($request->ajax()) {
        return datatables()->of($prodi)
            ->addIndexColumn()
            ->addColumn('fakultas', function ($row) {
                return $row->fakultas ? $row->fakultas->namafakultas : 'Tidak Ditemukan';  // Menampilkan nama fakultas
            })
            ->addColumn('ketua_prodi', function ($row) {
                return $row->pegawai ? $row->pegawai->namadekan : 'Tidak Ditemukan';  // Menampilkan nama ketua prodi
            })
            ->addColumn('action', function ($row) {
                // Tombol aksi seperti Edit dan Hapus
                return '
                    <a href="' . route('prodi-inisma.edit', $row->id) . '" class="btn btn-sm btn-warning">Edit</a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Hapus</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('prodi.index');
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        $pegawais = Pegawai::all(); // Jika Anda ingin mendapatkan data pegawai untuk ketua prodi
        return view('prodi.create', compact('fakultas', 'pegawais'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaprodi' => 'required|string|max:255',
            'kodeprodi' => 'required|string|max:10',
            'jenjang' => 'required|string',
            'akreditasi' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'deskripsisingkat' => 'required|string',
            'fakultas_id' => 'required|exists:fakultas,id',
            'ketua_prodi_id' => 'required|exists:pegawai,id',
        ]);

        Prodi::create($validated);

        // Mengembalikan response untuk AJAX
        return response()->json([
            'message' => 'Program Studi berhasil ditambahkan.'
        ]);
    }

    public function edit($id)
    {
        // Ambil data Prodi berdasarkan id
        $prodi = Prodi::findOrFail($id);
        
        // Ambil data Fakultas dan Pegawai untuk dropdown
        $fakultas = Fakultas::all();
        $pegawais = Pegawai::all();

        // Tampilkan halaman edit dengan data Prodi, Fakultas, dan Pegawai
        return view('prodi.edit', compact('prodi', 'fakultas', 'pegawais'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input form
        $request->validate([
            'namaprodi' => 'required|string|max:255',
            'kodeprodi' => 'required|string|max:50',
            'jenjang' => 'required|string|max:2',
            'akreditasi' => 'required|string|max:20',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'deskripsisingkat' => 'required|string',
            'fakultas_id' => 'required|exists:fakultas,id',
            'ketua_prodi_id' => 'required|exists:pegawai,id',
        ]);

        // Cari Prodi yang akan diupdate
        $prodi = Prodi::findOrFail($id);

        // Update data Prodi
        $prodi->update([
            'namaprodi' => $request->namaprodi,
            'kodeprodi' => $request->kodeprodi,
            'jenjang' => $request->jenjang,
            'akreditasi' => $request->akreditasi,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'deskripsisingkat' => $request->deskripsisingkat,
            'fakultas_id' => $request->fakultas_id,
            'ketua_prodi_id' => $request->ketua_prodi_id,
        ]);

        // Jika request Ajax, kirim response success
        if ($request->ajax()) {
            return response()->json(['message' => 'Program Studi berhasil diperbarui!']);
        }

        // Jika tidak Ajax, redirect ke halaman index dengan pesan sukses
        return redirect()->route('prodi-inisma.index')->with('success', 'Program Studi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Cari Prodi berdasarkan ID
        $prodi = Prodi::findOrFail($id);

        // Hapus Prodi
        $prodi->delete();

        // Jika request menggunakan AJAX, kembalikan response success
        if (request()->ajax()) {
            return response()->json(['message' => 'Program Studi berhasil dihapus!']);
        }

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('prodi-inisma.index')->with('success', 'Program Studi berhasil dihapus!');
    }
}
