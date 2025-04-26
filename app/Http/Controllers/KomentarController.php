<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PDF;
use Excel;
use App\Exports\KomentarExport;
use Carbon\Carbon;

class KomentarController extends Controller
{
    public function index(Request $request)
    {
        // Carbon::setLocale('id'); 
        if ($request->ajax()) {
            $komentar = Comment::with('post')->get();
            return DataTables::of($komentar)
                ->addIndexColumn()
                ->addColumn('post_title', function ($row) {
                    return $row->post->title ?? 'No Post';
                })
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)
                        ->setTimezone('Asia/Jakarta') // Atur zona waktu ke WIB
                        ->translatedFormat('d F Y - H:i'); // Format tanggal dan jam
                })
                // ->addColumn('created_at', function ($row) {
                //     return $row->created_at->format('d-m-Y H:i');
                // })
                // ->addColumn('action', function ($row) {
                //     return view('komentar.action', compact('row'));
                // })
                ->make(true);
        }

        $posts = Post::all();
        return view('komentar.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);

        return response()->json(['message' => 'Komentar berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $komentar = Comment::findOrFail($id);
        return response()->json($komentar);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
        ]);

        $komentar = Comment::findOrFail($id);
        $komentar->update([
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);

        return response()->json(['message' => 'Komentar berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        $komentar = Comment::findOrFail($id);
        $komentar->delete();

        return response()->json(['message' => 'Komentar berhasil dihapus.']);
    }
   
}
