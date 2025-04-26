<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Buku::all(); // Mengambil semua data buku
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('tahun_terbit', function ($row) {
                    // Format tahun terbit
                    return $row->tahun_terbit;
                })
                ->addColumn('file_buku', function ($buku) {
                    $fileUrl = $buku->file_buku
                        ? asset(  $buku->file_buku) // Sesuaikan dengan lokasi penyimpanan file
                        : null;
        
                    if ($fileUrl) {
                        return '<a href="' . $fileUrl . '" target="_blank" class="btn btn-link">Lihat File</a>';
                    } else {
                        return 'File tidak tersedia';
                    }
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-warning editBuku "
                data-id="' . $row->id . '"
                data-judul="' . $row->judul . '"
                data-penulis="' . $row->penulis . '"
                data-penerbit="' . $row->penerbit . '"
                data-tahun_terbit="' . $row->tahun_terbit . '"
                data-deskripsi="' . $row->deskripsi . '"
                data-status="' . $row->status . '">
                <i class="fas fa-edit"></i> Edit</button>
                        <button class="btn btn-danger delete-buku" data-id="' . $row->id . '"><i class="fas fa-trash"></i> Delete</button>';
                })
                ->rawColumns(['action','file_buku'])
                ->make(true);
        }

        return view('buku.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4',
            'deskripsi' => 'nullable|string',
            'file_buku' => 'nullable|mimes:pdf|max:2048', // File harus PDF dengan ukuran maksimal 2MB
            'status' => 'required|in:Tersedia,Tidak Tersedia', // Validasi status
        ]);

        $filePath = null;
        if ($request->hasFile('file_buku')) {
            $file = $request->file('file_buku');
            $filePath = 'buku_files/' . Str::random(40) . '.pdf';
            $file->move(public_path('buku_files'), $filePath);
        }

        Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'deskripsi' => $request->deskripsi,
            'file_buku' => $filePath,
            'status' => $request->status,
            'slug' => Str::uuid(), // Menggunakan UUID untuk slug
        ]);

        return response()->json(['success' => 'Buku berhasil ditambahkan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan.'], 404);
        }

        $data = [
            'judul' => $buku->judul,
            'penulis' => $buku->penulis,
            'penerbit' => $buku->penerbit,
            'tahun_terbit' => $buku->tahun_terbit,
            'deskripsi' => $buku->deskripsi,
            'file_buku' => $buku->file_buku,
            'status' => $buku->status,
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);  // Use find instead of findOrFail to avoid the exception
        if (!$buku) {
            return response()->json(['error' => 'Buku not found'], 404);
        }
        $request->validate([
            'judul' => 'string|max:255',
            'penulis' => 'string|max:255',
            'penerbit' => 'string|max:255',
            'tahun_terbit' => 'digits:4',
            'deskripsi' => 'nullable|string',
            'file_buku' => 'nullable|mimes:pdf|max:2048',
            'status' => 'in:Tersedia,Tidak Tersedia',
        ]);
    
        // Temukan buku yang akan diperbarui
        $buku = Buku::findOrFail($id);
    
        // Gunakan file lama jika tidak ada file baru
        $filePath = $buku->file_buku;
    
        // Cek apakah ada file baru
        if ($request->hasFile('file_buku')) {
            // Hapus file lama jika ada
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath)); // Menghapus file lama
            }
    
            // Simpan file baru
            $file = $request->file('file_buku');
            $filePath = 'buku_files/' . Str::random(40) . '.pdf';
            $file->move(public_path('buku_files'), $filePath); // Pindahkan file ke folder tujuan
        }
    
        // Perbarui data buku
        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'deskripsi' => $request->deskripsi,
            'file_buku' => $filePath, // Perbarui dengan file baru (atau file lama jika tidak ada file baru)
            'status' => $request->status,
        ]);

        return response()->json(['success' => 'Buku berhasil diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan.'], 404);
        }

        if ($buku->buku_files && file_exists(public_path($buku->buku_files))) {
            unlink(public_path($buku->buku_files));
        }

        $buku->delete();

        return response()->json(['success' => 'Buku berhasil dihapus.']);
    }


    public function getBuku($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['error' => 'Buku tidak ditemukan'], 404);
        }

        // Tambahkan URL file buku jika ada
        $buku->file_buku_url = $buku->file_buku
            ? asset('buku_files/' . $buku->file_buku)
            : null;

        return response()->json($buku);
    }
}
