<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Spatie\Image\Image;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Image as SpatieImage;
use File;
use Carbon\Carbon;

class CompanyProfileController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $company = CompanyProfile::query();

            return DataTables::of($company)
                ->addIndexColumn()
                ->addColumn('logo', function ($company) {
                    $imageUrl = $company->logo
                        ? asset($company->logo)
                        : asset('images/default.jpg'); // Gambar default jika tidak ada
                    return '<img src="' . $imageUrl . '" class="rounded" alt="Image" style="width: 50px; height: auto;">';
                })
                ->addColumn('founded_year', function ($company) {
                    // Menggunakan Carbon untuk memformat tahun berdiri
                    return Carbon::parse($company->founded_year)->translatedFormat('d F Y'); // Format: 27 Desember 2024
                })

                ->addColumn('action', function ($company) {
                    return '
                     <button class="btn btn-sm btn-primary edit-company" data-id="' . $company->id . '">
            <i class="fas fa-edit"></i> Edit
        </button>
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $company->id . '">
                        <i class="fas fa-trash"></i> Delete
                    </button>';
                })
                ->rawColumns(['action', 'logo'])
                ->make(true);
        }

        return view('company_profiles.index');
    }

    public function create()
    {
        return view('company_profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'history' => 'required',
            'vision' => 'required',
            'mission' => 'required',
            'founded_year' => 'required|date',
            'structure_image' => 'nullable|image',  // Struktur gambar (misal diagram struktur)
            'logo' => 'nullable|image',              // Logo perusahaan
        ]);

        // Ambil data dari request
        $data = $request->all();

        // Proses upload Struktur Image
        if ($request->hasFile('structure_image')) {
            $structureImage = $request->file('structure_image');

            // Tentukan path penyimpanan ke folder public/perusahaan
            $structureImagePath = 'perusahaan/' . uniqid() . '.webp';
            $structureImage->move(public_path('perusahaan'), $structureImagePath);

            // Konversi gambar ke format WebP menggunakan Spatie Image
            $imagePath = public_path($structureImagePath);
            Image::load($imagePath)
                ->format('webp')  // Mengonversi gambar ke WebP
                ->width(800)      // Sesuaikan dengan ukuran lebar
                ->height(600)     // Sesuaikan dengan ukuran tinggi
                ->save($imagePath); // Simpan file yang sudah diubah formatnya

            // Simpan path ke dalam data untuk disimpan ke database
            $data['structure_image'] = $structureImagePath;
        }

        // Proses upload Logo
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');

            // Tentukan path penyimpanan ke folder public/perusahaan
            $logoPath = 'perusahaan/' . uniqid() . '.webp';
            $logo->move(public_path('perusahaan'), $logoPath);

            // Konversi logo ke format WebP menggunakan Spatie Image
            $logoImagePath = public_path($logoPath);
            Image::load($logoImagePath)
                ->format('webp')  // Mengonversi logo ke WebP
                ->width(300)      // Sesuaikan dengan ukuran lebar
                ->height(300)     // Sesuaikan dengan ukuran tinggi
                ->save($logoImagePath); // Simpan file logo yang sudah diubah formatnya

            // Simpan path ke dalam data untuk disimpan ke database
            $data['logo'] = $logoPath;
        }

        // Simpan data profil perusahaan ke database
        CompanyProfile::create($data);

        // Kembalikan respons sukses
        return response()->json(['success' => 'Profile created successfully']);
    }

    public function edit($id)
    {
        try {
            $company = CompanyProfile::findOrFail($id); // Temukan data berdasarkan ID
            return response()->json($company); // Kirimkan data ke AJAX
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Ambil data perusahaan berdasarkan ID
            $company = CompanyProfile::findOrFail($id);

            // Validasi data
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'history' => 'required',
                'vision' => 'required',
                'mission' => 'required',
                'founded_year' => 'required|date',
                'structure_image' => 'nullable|image', // Struktur gambar (misal diagram struktur)
                'logo' => 'nullable|image',             // Logo perusahaan
            ]);

            // Ambil data dari request
            $data = $request->all();

            // Proses upload Struktur Image jika ada
            if ($request->hasFile('structure_image')) {
                // Hapus gambar lama jika ada
                if ($company->structure_image && file_exists(public_path($company->structure_image))) {
                    unlink(public_path($company->structure_image)); // Hapus file lama
                }

                $structureImage = $request->file('structure_image');
                $structureImagePath = 'perusahaan/' . uniqid() . '.webp';
                $structureImage->move(public_path('perusahaan'), $structureImagePath);

                // Konversi gambar ke format WebP menggunakan Spatie Image
                $imagePath = public_path($structureImagePath);
                Image::load($imagePath)
                    ->format('webp')
                    ->width(800)
                    ->height(600)
                    ->save($imagePath);

                $data['structure_image'] = $structureImagePath;
            }

            // Proses upload Logo jika ada
            if ($request->hasFile('logo')) {
                // Hapus logo lama jika ada
                if ($company->logo && file_exists(public_path($company->logo))) {
                    unlink(public_path($company->logo)); // Hapus file lama
                }

                $logo = $request->file('logo');
                $logoPath = 'perusahaan/' . uniqid() . '.webp';
                $logo->move(public_path('perusahaan'), $logoPath);

                // Konversi logo ke format WebP menggunakan Spatie Image
                $logoImagePath = public_path($logoPath);
                Image::load($logoImagePath)
                    ->format('webp')
                    ->width(300)
                    ->height(300)
                    ->save($logoImagePath);

                $data['logo'] = $logoPath;
            }

            // Perbarui data perusahaan
            $company->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Company profile berhasil diperbarui.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(CompanyProfile $company, $id)
    {
        try {
            // Temukan profil perusahaan berdasarkan ID
            $company = CompanyProfile::findOrFail($id);

            // Hapus file struktur image jika ada
            if ($company->structure_image && File::exists(public_path($company->structure_image))) {
                File::delete(public_path($company->structure_image));
            }

            // Hapus file logo jika ada
            if ($company->logo && File::exists(public_path($company->logo))) {
                File::delete(public_path($company->logo));
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
