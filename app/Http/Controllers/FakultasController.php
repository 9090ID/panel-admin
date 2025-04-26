<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Spatie\Image\Image;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Image as SpatieImage;
use File;
use Carbon\Carbon;

class FakultasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $fakultas = Fakultas::with('dekan')->get(); // Mengambil fakultas beserta data dekan

            return DataTables::of($fakultas)
                ->addIndexColumn()
                ->addColumn('fotofakultas', function ($fakultas) {
                    $imageUrl = $fakultas->fotofakultas
                        ? asset($fakultas->fotofakultas)
                        : asset('images/default.jpg'); // Gambar default jika tidak ada
                    return '<img src="' . $imageUrl . '" class="rounded" alt="Image" style="width: 50px; height: auto;">';
                })
                
                ->addColumn('dekan', function ($fakultas) {
                    return $fakultas->dekan ? $fakultas->dekan->namadekan : 'Tidak ada dekan';
                })
                ->addColumn('action', function ($fakultas) {
                    return '
                        <button class="btn btn-sm btn-primary edit-fakultas" data-id="' . $fakultas->id . '">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $fakultas->id . '">
                            <i class="fas fa-trash"></i> Delete
                        </button>';
                })
                ->rawColumns(['fotofakultas', 'action'])
                ->make(true);
        }


        $fakultas = Fakultas::all();
        $pegawaiss = Pegawai::all(); // Ambil semua pegawai (dekan)
        return view('fakultas.index', compact('pegawaiss', 'fakultas')); // Mengirim data pegawai ke view
    }
    public function create()
    {
        return view('fakultas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namafakultas' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'deskripsi_singkat' => 'required',
            'fotofakultas' => 'nullable|image',
            'akreditasi' => 'required',
            'dekan_id' => 'required|exists:pegawai,id'
        ]);

        $data = $request->all();

        // Generate slug with UUID
        $data['slug'] = Str::slug($data['namafakultas'] . '-' . Str::uuid());

        // Proses upload foto fakultas jika ada
        if ($request->hasFile('fotofakultas')) {
            $fotoFakultas = $request->file('fotofakultas');
            $fotoFakultasPath = 'fakultas/' . uniqid() . '.' . $fotoFakultas->getClientOriginalExtension();
            $fotoFakultas->move(public_path('fakultas'), $fotoFakultasPath);
            $data['fotofakultas'] = $fotoFakultasPath;
        }

       
        // Menyimpan data fakultas
        $fakultas = Fakultas::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Data Fakultas berhasil disimpan!',
            'data' => $fakultas,
        ]);

        
    }

    public function edit($id)
    {
        $fakultas = Fakultas::findOrFail($id);
        return response()->json($fakultas);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namafakultas' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'deskripsi_singkat' => 'required',
            'fotofakultas' => 'nullable|image',
            'akreditasi' => 'required',
            'dekan_id' => 'required|exists:pegawai,id'
        ]);

        $fakultas = Fakultas::findOrFail($id);
        $data = $request->all();
        $data['slug'] = Str::slug($data['namafakultas'] . '-' . Str::uuid());
        // Proses upload foto fakultas jika ada
        if ($request->hasFile('fotofakultas')) {
            // Hapus foto lama jika ada
            if ($fakultas->fotofakultas && file_exists(public_path($fakultas->fotofakultas))) {
                unlink(public_path($fakultas->fotofakultas));
            }
        
            // Upload foto baru
            $fotoFakultas = $request->file('fotofakultas');
            $fotoFakultasPath = 'fakultas/' . uniqid() . '.' . $fotoFakultas->getClientOriginalExtension();
            $fotoFakultas->move(public_path('fakultas'), $fotoFakultasPath);
            $data['fotofakultas'] = $fotoFakultasPath;
        }
        // Update data fakultas
        $fakultas->update($data);

        return response()->json(['success' => 'Fakultas updated successfully!']);
    }

    public function destroy($id)
    {
        $fakultas = Fakultas::findOrFail($id);
        $fakultas->delete();

        return response()->json(['success' => 'Fakultas deleted successfully!']);
    }
}
