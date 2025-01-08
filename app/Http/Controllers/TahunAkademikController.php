<?php

namespace App\Http\Controllers;

use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class TahunAkademikController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TahunAkademik::select(['id', 'nama_tahun', 'semester', 'aktif']);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-warning btn-sm edit-tahun-akademik" data-id="' . $row->id . '"><i class="fa fa-edit"></i> Edit</button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i> Hapus</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('tahun_akademik.index'); // Pastikan view ini ada
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tahun' => 'required|string|max:255',
            'semester' => 'required|string|in:Ganjil,Genap',
            'aktif' => 'boolean',
        ]);

        TahunAkademik::updateOrCreate(
            ['id' => $request->id],
            [
                'nama_tahun' => $request->nama_tahun,
                'semester' => $request->semester,
                'aktif' => $request->aktif ? 1 : 0, // Mengubah checkbox menjadi boolean
            ]
        );

        return response()->json(['message' => 'Tahun akademik berhasil disimpan.']);
    }

    public function edit($id)
    {
        $tahunAkademik = TahunAkademik::findOrFail($id);
        return response()->json($tahunAkademik);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_tahun' => 'required|string|max:255',
            'semester' => 'required|string|in:Ganjil,Genap',
            'aktif' => 'boolean',
        ]);

        $tahunAkademik = TahunAkademik::findOrFail($id);
        $tahunAkademik->update([
            'nama_tahun' => $request->nama_tahun,
            'semester' => $request->semester,
            'aktif' => $request->aktif ? 1 : 0, // Mengubah checkbox menjadi boolean
        ]);

        return response()->json(['message' => 'Tahun akademik berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        $tahunAkademik = TahunAkademik::findOrFail($id);
        $tahunAkademik->delete();

        return response()->json(['message' => 'Tahun akademik berhasil dihapus!']);
    }
}