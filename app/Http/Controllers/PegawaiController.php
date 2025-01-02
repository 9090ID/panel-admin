<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\File;
use Spatie\Image\Image as SpatieImage;
use File;
use Illuminate\Support\Facades\Log;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Mengambil data pegawai bersama dengan relasi jabatan
            $data = Pegawai::with('jabatan')  // Relasi dengan jabatan
                ->select('pegawai.*')  // Pilih kolom yang diperlukan
                ->get();

            // Menyiapkan data untuk ditampilkan di DataTables
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('fotodekan', function ($data) {
                    $imageUrl = $data->fotodekan
                        ? asset($data->fotodekan)
                        : asset('images/default.jpg'); // Gambar default jika tidak ada
                    return '<img src="' . $imageUrl . '" class="rounded" alt="Image" style="width: 50px; height: auto;">';
                })
                ->addColumn('jabatan', function ($data) {
                    // Menampilkan nama jabatan
                    return $data->jabatan ? $data->jabatan->namajabatan : '-';
                })
                ->addColumn('action', function ($data) {
                    // Tombol edit dan delete
                    return '<button class="btn btn-warning btn-sm edit-pegawai" data-id="' . $data->id . '"><i class="fa fa-edit"></i> Edit</button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="' . $data->id . '"><i class="fa fa-trash"></i> Hapus</button>';
                })
                ->rawColumns(['action', 'fotodekan']) // Menandai kolom tertentu untuk tidak diproses sebagai teks biasa
                ->make(true);
        }

        $jabatan = Jabatan::all();  // Ambil semua data jabatan untuk ditampilkan di form

        return view('pegawai.index', compact('jabatan'));
    }
    public function edit($id)
    {
        // Ambil data pegawai beserta jabatan yang terkait
        $pegawai = Pegawai::with('jabatan')->findOrFail($id);

        // Ambil data jabatan untuk dropdown
        $jabatan = Jabatan::all();

        return response()->json([
            'pegawai' => $pegawai,
            'jabatan' => $jabatan,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi data yang diterima
        $request->validate([
            'namadekan' => 'required|string',
            'nip' => 'required|string',
            'jabatan_id' => 'required|exists:jabatan,id',
            'lulusanterakhir' => 'required|string',
            'fotodekan' => 'nullable|image', // Foto Dekan
        ]);

        // Ambil data dari request
        $data = $request->all();

        // Proses upload foto dekan jika ada
        if ($request->hasFile('fotodekan')) {
            $fotodekan = $request->file('fotodekan');
            $fotodekanPath = 'fotopegawai/' . uniqid() . '.webp';
            $fotodekan->move(public_path('fotopegawai'), $fotodekanPath);

            // Konversi gambar ke format WebP
            $imagePath = public_path($fotodekanPath);
            SpatieImage::load($imagePath)
                ->format('webp')
                ->width(800)
                ->height(600)
                ->save($imagePath);

            $data['fotodekan'] = $fotodekanPath;
        }

        // Simpan data pegawai ke database
        try {
            Pegawai::create($data);
            return response()->json(['success' => 'Data pegawai berhasil ditambahkan']);
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan data pegawai: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data pegawai.'], 500);
        }
    }

    public function update(Request $request, $id)
    {

        // Validasi data yang diterima
        $request->validate([
            'namadekan' => 'required|string',
            'nip' => 'required|string',
            'jabatan_id' => 'required|exists:jabatan,id',
            'lulusanterakhir' => 'required|string',
            'fotodekan' => 'nullable|image',  // Foto Dekan
        ]);

        $pegawai = Pegawai::find($id);
        if (!$pegawai) {
            return response()->json(['error' => 'Data pegawai tidak ditemukan'], 404);
        }

        // Update data pegawai
        $pegawai->namadekan = $request->namadekan;
        $pegawai->nip = $request->nip;
        $pegawai->jabatan_id = $request->jabatan_id;
        $pegawai->lulusanterakhir = $request->lulusanterakhir;

        // Proses foto dekan jika ada
    if ($request->hasFile('fotodekan')) {
        // Hapus foto lama jika ada
        if ($pegawai->fotodekan && file_exists(public_path($pegawai->fotodekan))) {
            unlink(public_path($pegawai->fotodekan));
        }

        // Ambil foto baru
        $fotodekan = $request->file('fotodekan');
        $fotodekanPath = 'fotopegawai/' . uniqid() . '.webp';

        // Proses dan simpan foto dengan format WebP menggunakan Spatie Image
        SpatieImage::load($fotodekan)
            ->format('webp') // Mengubah format menjadi WebP
            ->width(800)      // Menentukan lebar gambar
            ->height(600)     // Menentukan tinggi gambar
            ->save(public_path($fotodekanPath)); // Menyimpan gambar ke direktori

        // Simpan path foto ke database
        $pegawai->fotodekan = $fotodekanPath;
    }

        $pegawai->save();

        return response()->json(['success' => 'Data pegawai berhasil diperbarui']);
    }



    public function destroy(Pegawai $company, $id)
    {
        try {
            // Temukan profil perusahaan berdasarkan ID
            $company = Pegawai::findOrFail($id);

            // Hapus file struktur image jika ada
            if ($company->fotodekan && File::exists(public_path($company->fotodekan))) {
                File::delete(public_path($company->fotodekan));
            }
            // Hapus data dari database
            $company->delete();

            return response()->json([
                'success' => true,
                'message' => 'Profil perusahaan berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
