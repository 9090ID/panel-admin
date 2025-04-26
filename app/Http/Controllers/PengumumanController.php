<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use App\Models\Category;
use Ramsey\Uuid\Guid\Guid;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Mengambil data pengumuman dengan relasi kategori
            $data = Pengumuman::with('categories')->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('categories', function ($row) {
                    // Menggabungkan nama kategori, dengan pengecekan jika tidak ada kategori
                    return $row->categories->isEmpty() ? 'No Category' : $row->categories->pluck('name')->implode(', ');
                })
                ->addColumn('tanggalpublish', function ($row) {
                    // Mengubah format tanggalpublish ke format Indonesia
                    return Carbon::parse($row->tanggalpublish)->isoFormat('D MMMM YYYY'); // Format Indonesia (contoh: 1 Januari 2025)
                })
                ->addColumn('action', function ($row) {
                    return '
                            <a href="' . route('pengumuman.edit', $row->id) . '" class="btn btn-info edit-btn"><i class="fas fa-edit"></i> Edit</a>
                            <button class="btn btn-danger delete-btn" data-id="' . $row->id . '"><i class="fas fa-trash"></i> Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pengumuman.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Mendapatkan semua kategori
        return view('pengumuman.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isipengumuman' => 'required',
            'tanggalpublish' => 'date',
            'categories' => 'required|array', // Harus array untuk kategori
            'categories.*' => 'exists:categories,id', // Validasi setiap kategori ada di tabel categories
            'file' => 'nullable|mimes:pdf|max:2048', // File harus PDF dengan ukuran maksimal 2MB
            'status' => 'required|in:drafted,published', // Validasi status
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Menyimpan file di public/filepengumuman dengan nama unik
            $filePath = 'filepengumuman/' . Str::random(40) . '.pdf';
            $file->move(public_path('filepengumuman'), $filePath);
        }

        // Simpan data pengumuman
        $pengumuman = Pengumuman::create([
            'judul' => $request->judul,
            'author' => $request->author,
            'isipengumuman' => $request->isipengumuman,
            'tanggalpublish' => $request->tanggalpublish,
            'file' => $filePath,
            'status' => $request->status,
            'slug' => Str::uuid(), // Slug menggunakan UUID
        ]);

        // Sinkronisasi kategori (tabel pivot)
        $pengumuman->categories()->sync($request->categories);

        return response()->json(['success' => 'Pengumuman berhasil ditambahkan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         // Mengambil data pengumuman berdasarkan ID, termasuk kategori terkait
    $pengumuman = Pengumuman::with('categories')->find($id);

    // Jika pengumuman tidak ditemukan, kembalikan respons error
    if (!$pengumuman) {
        return response()->json(['message' => 'Pengumuman tidak ditemukan.'], 404);
    }

    // Menyiapkan data untuk respons
    $data = [
        'judul' => $pengumuman->judul,
        'author' => $pengumuman->author,
        'isipengumuman' => $pengumuman->isipengumuman,
        'tanggalpublish' => Carbon::parse($pengumuman->tanggalpublish)->translatedFormat('d F Y'), // Format tanggal Indonesia
        'file' => $pengumuman->file,
        'categories' => $pengumuman->categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        }),
    ];

    return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         // Cari pengumuman berdasarkan ID
    $pengumuman = Pengumuman::with('categories')->findOrFail($id);

    // Ambil semua kategori untuk dipilih pada form
    $categories = Category::all();

    // Tampilkan halaman edit dengan data pengumuman dan kategori
    return view('pengumuman.edit', compact('pengumuman', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
    $request->validate([
        'judul' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'isipengumuman' => 'required',
        'tanggalpublish' => 'date',
        'categories' => 'required|array',
        'categories.*' => 'exists:categories,id', // Validasi kategori
        'file' => 'nullable|mimes:pdf|max:2048', // File harus PDF dengan ukuran maksimal 2MB
        'status' => 'required|in:drafted,published', // Validasi status
    ]);

    // Ambil pengumuman yang akan diperbarui
    $pengumuman = Pengumuman::findOrFail($id);

    // Jika file baru di-upload, hapus file lama dan simpan file baru
    $filePath = $pengumuman->file; // Gunakan file lama jika tidak ada file baru
    if ($request->hasFile('file')) {
        // Hapus file lama jika ada
        if (file_exists(public_path($pengumuman->file))) {
            unlink(public_path($pengumuman->file));
        }

        // Simpan file baru
        $file = $request->file('file');
        $filePath = 'filepengumuman/' . Str::random(40) . '.pdf';
        $file->move(public_path('filepengumuman'), $filePath);
    }

    // Update data pengumuman
    $pengumuman->update([
        'judul' => $request->judul,
        'author' => $request->author,
        'isipengumuman' => $request->isipengumuman,
        'tanggalpublish' => $request->tanggalpublish,
        'file' => $filePath,
        'status' => $request->status,
        // Tidak perlu mengubah slug, biarkan tetap menggunakan slug yang lama
    ]);

    // Sinkronisasi kategori (tabel pivot)
    $pengumuman->categories()->sync($request->categories);

    // Response success
    return response()->json(['success' => 'Pengumuman berhasil diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       // Mencari pengumuman berdasarkan ID
    $pengumuman = Pengumuman::find($id);

    // Jika pengumuman tidak ditemukan
    if (!$pengumuman) {
        return response()->json(['message' => 'Pengumuman tidak ditemukan.'], 404);
    }

    // Menghapus file terkait jika ada
    if ($pengumuman->file && file_exists(public_path($pengumuman->file))) {
        unlink(public_path($pengumuman->file));
    }

    // Menghapus data pengumuman
    $pengumuman->delete();

    return response()->json(['success' => 'Pengumuman berhasil dihapus.']);
    }
}
