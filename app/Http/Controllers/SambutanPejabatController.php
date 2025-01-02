<?php

namespace App\Http\Controllers;

use App\Models\SambutanPejabat;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\PeriodeJabatan;
use Spatie\Image\Image as SpatieImage;
use Spatie\Image\Manipulations;
use Illuminate\Http\Request;

class SambutanPejabatController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SambutanPejabat::with(['pegawai', 'jabatan'])->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('namapejabat', fn($row) => $row->pegawai->namadekan ?? '-')
                ->addColumn('namajabatan', fn($row) => $row->jabatan->namajabatan ?? '-')
                ->addColumn('totalmenjabat', fn($row) => $row->total_menjabat ?? '-')
                ->addColumn('fotopejabat', function ($row) {
                    if ($row->fotopejabat) {
                        $fotoUrl = asset('/' . $row->fotopejabat); // Jalur ke gambar di public storage
                        return '<img src="' . $fotoUrl . '" alt="Foto Pejabat" class="img-fluid rounded" width="50" height="50">';
                    }
                    return '-';
                })
                ->addColumn('action', function ($row) {
                    $viewBtn = '<button class="btn btn-info btn-sm view-btn" data-id="' . $row->id . '"><i class="fas fa-eye"></i> Lihat</button>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '"><i class="fas fa-trash"></i>  Hapus</button>';
                    return $viewBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action', 'fotopejabat'])
                ->make(true);
        }
      
        $pegawais = Pegawai::all();
        return view('sambutan-pejabat.index', compact( 'pegawais'));
    }

    public function create()
    {
        $pegawais = Pegawai::all(); // Ambil data dari tabel pegawai
        $jabatans = Jabatan::all(); // Ambil data dari tabel jabatan
       
        return view('sambutan-pejabat.create', compact('pegawais', 'jabatans'));
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'tglmulaimenjabat' => 'required|date',
            'akhirjabatan' => 'required|date|after_or_equal:tglmulaimenjabat',
            'riwayathidup' => 'required|string',
            'isisambutan' => 'required|string',
            'fotopejabat' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Proses foto menggunakan Spatie Image
        if ($request->hasFile('fotopejabat')) {
            $fotodekan = $request->file('fotopejabat');
            $fotodekanPath = 'fotopejabat/' . uniqid() . '.webp';
            $fotodekan->move(public_path('fotopejabat'), $fotodekanPath);

            // Konversi gambar ke format WebP
            $imagePath = public_path($fotodekanPath);
            SpatieImage::load($imagePath)
                ->format('webp')
                ->width(800)
                ->height(600)
                ->save($imagePath);

            $data['fotopejabat'] = $fotodekanPath;
        }

        // Menghitung lama menjabat
        $startDate = new \DateTime($request->tglmulaimenjabat);
        $endDate = new \DateTime($request->akhirmenjabat);
        $interval = $startDate->diff($endDate);
        $data['lamamenjabat'] = $interval->y . ' tahun, ' . $interval->m . ' bulan, ' . $interval->d . ' hari';

        // Simpan data ke dalam tabel
        SambutanPejabat::create([
            'pegawai_id' => $data['pegawai_id'],
            'jabatan_id' => $data['jabatan_id'],
            'tglmulaimenjabat' => $data['tglmulaimenjabat'],
            'akhirjabatan' => $data['akhirjabatan'],
            'riwayathidup' => $data['riwayathidup'],
            'isisambutan' => $data['isisambutan'],
            'fotopejabat' => $data['fotopejabat'] ?? null,
            'lamamenjabat' => $data['lamamenjabat'],
        ]);

        // Response sukses
        return response()->json(['success' => 'Data Sambutan Pejabat berhasil ditambahkan!'], 201);
    }

    public function destroy(SambutanPejabat $sambutanPejabat)
    {
        $sambutanPejabat->delete();
        return response()->json(['success' => 'Data berhasil dihapus']);
    }

    public function show($id)
    {
        // Ambil data sambutan pejabat berdasarkan ID
        // Ambil data sambutan pejabat berdasarkan ID
        $sambutanPejabat = SambutanPejabat::with(['pegawai', 'jabatan'])->findOrFail($id);

        // Hitung lama menjabat
        $lamaMenjabat = '-';
        if ($sambutanPejabat->jabatan && $sambutanPejabat->jabatan->tglmulaimenjabat && $sambutanPejabat->jabatan->akhirjabatan) {
            $start = \Carbon\Carbon::parse($sambutanPejabat->jabatan->tglmulaimenjabat);
            $end = \Carbon\Carbon::parse($sambutanPejabat->jabatan->akhirjabatan);
            $duration = $start->diff($end);
            $lamaMenjabat = $duration->y . ' Tahun ' . $duration->m . ' Bulan ' . $duration->d . ' Hari';
        }

        return response()->json([
            'sambutanPejabat' => $sambutanPejabat,
            'lamaMenjabat' => $lamaMenjabat,
        ]);
    }
}
