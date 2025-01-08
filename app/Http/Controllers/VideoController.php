<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video; // Pastikan model Video diimpor
use Yajra\DataTables\Facades\DataTables;
use Ramsey\Uuid\Uuid;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Video::select(['id', 'title', 'urlvideo', 'slug']);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-warning btn-sm edit-video" data-id="' . $row->id . '"><i class="fa fa-edit"></i> Edit</button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i> Hapus</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('videos.index'); // Pastikan view ini ada
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'urlvideo' => 'required|url',
        ]);
    
        // Menghasilkan UUID untuk slug
        $slug = (string) Uuid::uuid4();
    
        $video = Video::updateOrCreate(
            ['id' => $request->id],
            [
                'title' => $request->title,
                'urlvideo' => $request->urlvideo,
                'slug' => $slug // Menggunakan UUID sebagai slug
            ]
        );

        return response()->json(['message' => 'Video berhasil disimpan.']);
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return response()->json($video);
    }

    public function show()
    {
        $videos = Video::all();  // Ambil semua data video

        // Mengembalikan data video dalam bentuk JSON
        return response()->json([
            'videos' => $videos
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'urlvideo' => 'required|url',
        ]);

       // Cari video berdasarkan ID
    $video = Video::findOrFail($id);

    // Menghasilkan UUID untuk slug
    $slug = (string) Uuid::uuid4();

    // Perbarui data
    $video->update([
        'title' => $request->title,
        'urlvideo' => $request->urlvideo,
        'slug' => $slug // Menggunakan UUID sebagai slug
    ]);


        // Kembalikan respons sukses
        return response()->json(['message' => 'Video berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        // Cari video berdasarkan ID
        $video = Video::findOrFail($id);

        // Hapus data
        $video->delete();

        // Kembalikan respons sukses
        return response()->json(['message' => 'Video berhasil dihapus!']);
    }
}