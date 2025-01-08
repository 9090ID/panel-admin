<?php

namespace App\Http\Controllers;

use App\Models\KalenderAkademik;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use App\Exports\KalenderAkademikExport;
use Maatwebsite\Excel\Facades\Excel;
use loadView;
// Pastikan Anda mengimpor PDF dengan benar

class KalenderAkademikController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = KalenderAkademik::with('tahunAkademik')->select(['id', 'tahun_akademik_id', 'nama_event', 'tanggal_mulai', 'tanggal_selesai', 'deskripsi']);
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('tahun_akademik', function ($row) {
                    return $row->tahunAkademik->nama_tahun . ' ' . $row->tahunAkademik->semester;
                })
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-warning btn-sm edit-kalender" data-id="' . $row->id . '"><i class="fa fa-edit"></i> Edit</button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '"><i class="fa fa-trash"></i> Hapus</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $tahunAkademik = TahunAkademik::where('aktif', true)->get(); // Ambil tahun akademik aktif
        return view('kalender_akademik.index', compact('tahunAkademik'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_akademik_id.*' => 'required|exists:tahun_akademik,id',
            'nama_event.*' => 'required|string|max:255',
            'tanggal_mulai.*' => 'required|date',
            'tanggal_selesai.*' => 'nullable|date|after_or_equal:tanggal_mulai.*',
            'deskripsi.*' => 'nullable|string',
        ]);

        // Loop untuk menyimpan data multiple
        foreach ($request->nama_event as $key => $value) {
            KalenderAkademik::create([
                'tahun_akademik_id' => $request->tahun_akademik_id[$key],
                'nama_event' => $value,
                'tanggal_mulai' => $request->tanggal_mulai[$key],
                'tanggal_selesai' => $request->tanggal_selesai[$key],
                'deskripsi' => $request->deskripsi[$key],
            ]);
        }

        return response()->json(['message' => 'Kalender akademik berhasil disimpan.']);
    }

    public function edit($id)
    {
        $kalenderAkademik = KalenderAkademik::findOrFail($id);
        return response()->json($kalenderAkademik);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'nama_event' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable|string',
        ]);

        $kalenderAkademik = KalenderAkademik::findOrFail($id);
        $kalenderAkademik->update([
            'tahun_akademik_id' => $request->tahun_akademik_id,
            'nama_event' => $request->nama_event,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json(['message' => 'Kalender akademik berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        $kalenderAkademik = KalenderAkademik::findOrFail($id);
        $kalenderAkademik->delete();

        return response()->json(['message' => 'Kalender akademik berhasil dihapus!']);
    }
    public function downloadPDF(Request $request)
    {
        $tahunAkademikId = $request->query('tahun_akademik_id');

        // Validasi input
        if (!$tahunAkademikId) {
            return response()->json(['error' => 'Tahun akademik diperlukan.'], 400);
        }
    
        // Ambil data kalender akademik berdasarkan tahun
        $kalenderData = KalenderAkademik::where('tahun_akademik_id', $tahunAkademikId)->get();
    
        // Ambil nama tahun akademik dan semester
        $tahunAkademik = TahunAkademik::find($tahunAkademikId);
    
        // Generate PDF
        $pdf = PDF::loadView('pdf.kalender', [
            'kalenderData' => $kalenderData,
            'tahunAkademik' => $tahunAkademik ? $tahunAkademik->nama_tahun : 'Tahun Akademik Tidak Ditemukan',
            'semester' => $tahunAkademik ? $tahunAkademik->semester : 'Semester Tidak Ditemukan'
        ]);
    
        // Mengatur header untuk mengunduh file PDF
        return $pdf->download('kalender_akademik.pdf');
    // return view('pdf.kalender', compact('tahunAkademik', 'kalenderData','semester'));
    }

    // Metode untuk mengunduh Excel
    public function downloadExcel(Request $request)
    {
        $tahunAkademikId = $request->query('tahun_akademik_id');

        // Validasi input
        if (!$tahunAkademikId) {
            return response()->json(['error' => 'Tahun akademik diperlukan.'], 400);
        }

        // Menggunakan Maatwebsite Excel untuk mengunduh
        return Excel::download(new KalenderAkademikExport($tahunAkademikId), 'kalender_akademik.xlsx');
    }
}