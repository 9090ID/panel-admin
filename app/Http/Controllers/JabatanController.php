<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
use Yajra\DataTables\Facades\DataTables;
class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Jabatan::select(['id', 'namajabatan', 'status']);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-warning btn-sm edit-jabatan" data-id="' . $row->id . '"><i class="fa fa-edit"></i> Edit</button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i> Hapus</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('jabatans.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namajabatan' => 'required|string|max:255',
            'status' => 'required|in:aktif,non_aktif',
        ]);

        $jabatan = Jabatan::updateOrCreate(
            ['id' => $request->id],
            ['namajabatan' => $request->namajabatan, 'status' => $request->status]
        );

        return response()->json(['message' => 'Jabatan berhasil disimpan.']);
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return response()->json($jabatan);
    }
    public function show()
    {
        $jabatan = Jabatan::all();  // Ambil semua data jabatan

        // Mengembalikan data jabatan dalam bentuk JSON
        return response()->json([
            'jabatan' => $jabatan
        ]);
    
    }
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'namajabatan' => 'required|string|max:255',
            'status' => 'required|in:aktif,non_aktif',
        ]);

        // Cari jabatan berdasarkan ID
        $jabatan = Jabatan::findOrFail($id);

        // Perbarui data
        $jabatan->update([
            'namajabatan' => $request->namajabatan,
            'status' => $request->status,
        ]);

        // Kembalikan respons sukses
        return response()->json(['message' => 'Jabatan berhasil diperbarui!']);
    }
    public function destroy($id)
    {
        // Cari jabatan berdasarkan ID
        $jabatan = Jabatan::findOrFail($id);

        // Hapus data
        $jabatan->delete();

        // Kembalikan respons sukses
        return response()->json(['message' => 'Jabatan berhasil dihapus!']);
    }
}

