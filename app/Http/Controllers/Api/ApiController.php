<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Category;
use App\Models\Post;
use App\Models\pengumuman;
use App\Models\SambutanPejabat;
use App\Models\CompanyProfile;
use App\Models\Video;
use App\Models\RunningText;
use App\Models\KalenderAkademik;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;


class ApiController extends Controller
{
    // Menampilkan data mahasiswa
    public function mahasiswaIndex()
    {
        $mahasiswa = Mahasiswa::with('prodi')->get(); // Menampilkan semua mahasiswa dengan relasi prodi
        return response()->json($mahasiswa);
    }

    // Menampilkan data fakultas
    public function fakultasIndex()
    {
        $fakultas = Fakultas::all(); // Menampilkan semua fakultas
        return response()->json($fakultas);
    }
    public function tahunIndex()
    {
        $tahun = TahunAkademik::all(); // Menampilkan semua fakultas
        return response()->json($tahun);
    }
    public function kalenderIndex(Request $request)
    {
       $query = KalenderAkademik::query();

// Filter berdasarkan tahun akademik
if ($request->has('tahun_akademik_id') && $request->tahun_akademik_id != '') {
    $query->where('tahun_akademik_id', $request->tahun_akademik_id);
}

// Filter berdasarkan semester
if ($request->has('semester') && $request->semester != '') {
    $query->whereHas('tahunAkademik', function($q) use ($request) {
        $q->where('semester', $request->semester);
    });
}

// Ambil data kalender akademik
$kalenderAkademik = $query->with('tahunAkademik')->get();

// Format response to include semester
$responseData = $kalenderAkademik->map(function($item) {
    return [
        'id' => $item->id,
        'nama_event' => $item->nama_event,
        'tanggal_mulai' => $item->tanggal_mulai,
        'tanggal_selesai' => $item->tanggal_selesai,
        'semester' => $item->tahunAkademik->semester, // Include semester
    ];
});

return response()->json($responseData);
    }
    

    // Menampilkan data prodi
    public function prodiIndex()
    {
        $prodi = Prodi::all(); // Menampilkan semua prodi
        return response()->json($prodi);
    }
    public function profileIndex()
    {
        $profile = CompanyProfile::latest()->take(1)->get(); // Menampilkan semua prodi
        return response()->json($profile);
    }
    public function postsAllIndex()
    {
        $posts = Post::with('categories') // Menambahkan relasi kategori
             ->latest()           // Mengurutkan berdasarkan created_at dari yang terbaru
             ->get();
        return response()->json($posts);
    }
    public function postsIndex()
    {
        $posts = Post::with('categories') // Menambahkan relasi kategori
             ->latest()           // Mengurutkan berdasarkan created_at dari yang terbaru
             ->take(6)            // Membatasi hanya 3 post yang ditampilkan
             ->get();
        return response()->json($posts);
    }

    public function videoIndex()
    {
        $video = Video::latest()->take(3)->get();
        return response()->json($video);
    }

    public function runningIndex()
    {
        $running = RunningText::latest()->take(10)->get();
        return response()->json($running);
    }
    public function pengumumanIndex()
    {
        
        $pengumuman = pengumuman::with('categories') // Menambahkan relasi kategori
             ->latest()           // Mengurutkan berdasarkan created_at dari yang terbaru
             ->take(4)            // Membatasi hanya 3 post yang ditampilkan
             ->get();
        return response()->json($pengumuman);
    }
    public function showBySlug($slug)
        {
    // Gunakan eager loading untuk relasi categories
    $post = Post::with('categories')->where('slug', $slug)->first();

    if ($post) {
        return response()->json($post);
    } else {
        return response()->json(['error' => 'Post not found'], 404);
    }

    }

    public function showBySlugpengumuman($slug)
        {
    // Gunakan eager loading untuk relasi categories
    $post = pengumuman::with('categories')->where('slug', $slug)->first();

    if ($post) {
        return response()->json($post);
    } else {
        return response()->json(['error' => 'Post not found'], 404);
    }

    }
    public function fakBySlug($slug)
        {
    // Gunakan eager loading untuk relasi categories
    $fakultas = Fakultas::where('slug', $slug)->first();

    if ($fakultas) {
        return response()->json($fakultas);
    } else {
        return response()->json(['error' => 'Post not found'], 404);
    }

    }

    public function hitungMahasiswa()
    {
        $count = DB::table('mahasiswa')->count();
        return response()->json(['total' => $count]);
    }

    public function hitungDosen()
    {
        $counts = DB::table('pegawai')->count();
        return response()->json(['count' => $counts]);
    }

    public function hitungFakultas()
    {
        $counts = DB::table('fakultas')->count();
        return response()->json(['countf' => $counts]);
    }
    public function hitungProdi()
    {
        $counts = DB::table('prodis')->count();
        return response()->json(['countp' => $counts]);
    }

    public function sambutanIndex()
    {
      $sambutan = SambutanPejabat::with(['pegawai', 'jabatan'])
    ->whereHas('jabatan', function ($query) {
        $query->where('namajabatan', 'rektor');
    })
    ->limit(1)
    ->first();
        return response()->json($sambutan);
    }

    public function pimpinanIndex()
    {
     $sambutan = SambutanPejabat::select('sambutan_pejabat.*') // Ambil semua kolom dari sambutan_pejabat
            ->join('jabatan', 'sambutan_pejabat.jabatan_id', '=', 'jabatan.id') // Ganti 'jabatan_id' dan 'id' sesuai dengan kolom yang benar
            ->orderByRaw("CASE 
                WHEN jabatan.namajabatan = 'Ketua Yayasan Inisma' THEN 1 
                WHEN jabatan.namajabatan = 'Rektor' THEN 2 
                WHEN jabatan.namajabatan = 'Wakil Rektor Bidang Akademik dan Kemahasiswaan' THEN 3 
                WHEN jabatan.namajabatan = 'Wakil Rektor Bidang Administrasi Umum, Keuangan dan Sumber Daya Manusia' THEN 4 
                ELSE 3 
            END")
            ->with(['pegawai', 'jabatan']) // Eager load relasi jika diperlukan
            ->get(); // Mengambil semua data

        return response()->json($sambutan);

  
    }

    public function logoIndex()
    {
      // Cari data berdasarkan nama
        $company = CompanyProfile::where('name', 'Institut Islam Muaro Jambi')->first();

        // Jika data ditemukan, kembalikan logo
        if ($company) {
            return response()->json([
                'success' => true,
                'logo' => $company->logo // Asumsikan kolom "logo" menyimpan path/logo URL
            ]);
        }

        // Jika data tidak ditemukan
        return response()->json([
            'success' => false,
            'message' => 'Company not found'
        ], 404);
    
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
    }




}
