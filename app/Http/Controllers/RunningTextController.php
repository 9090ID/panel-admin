<?php

namespace App\Http\Controllers;

use App\Models\RunningText;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class RunningTextController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RunningText::select(['id', 'judul', 'isi', 'slug', 'status']);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-warning btn-sm edit-running-text" data-id="' . $row->id . '"><i class="fa fa-edit"></i> Edit</button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i> Hapus</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('running_texts.index'); // Pastikan view ini ada
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        $slug = Str::slug($request->judul) . '-' . uniqid(); // Menghasilkan slug

        RunningText::updateOrCreate(
            ['id' => $request->id],
            [
                'judul' => $request->judul,
                'isi' => $request->isi,
                'slug' => $slug,
                'status' => $request->status,
            ]
        );

        return response()->json(['message' => 'Running text berhasil disimpan.']);
    }

    public function edit($id)
    {
        $runningText = RunningText::findOrFail($id);
        return response()->json($runningText);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        $runningText = RunningText::findOrFail($id);
        $slug = Str::slug($request->judul) . '-' . uniqid(); // Perbarui data
        $runningText->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'slug' => $slug,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Running text berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        $runningText = RunningText::findOrFail($id);
        $runningText->delete();

        return response()->json(['message' => 'Running text berhasil dihapus!']);
    }
}