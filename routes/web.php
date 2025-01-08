<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\SambutanPejabatController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\KhususController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\RunningTextController;
use App\Http\Controllers\TahunAkademikController;
use App\Http\Controllers\KalenderAkademikController;

use App\Models\Pengumuman;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class);
    Route::get('user/show', [UserController::class, 'show'])->name('user.show');
    Route::post('/users/{id}/change-password', [UserController::class, 'changePassword'])->name('users.changePassword');
    Route::resource('/categories', CategoryController::class);
    Route::resource('/posts', PostController::class);
    Route::resource('/company-profiles', CompanyProfileController::class);
    Route::resource('/fakultas-inisma', FakultasController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::get('jabatan/data', [UserController::class, 'show'])->name('jabatan.data');
    Route::resource('kepeg-inisma', PegawaiController::class);
    Route::resource('prodi-inisma', ProdiController::class);
    Route::resource('sambutan-pejabat', SambutanPejabatController::class);
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('videos', VideoController::class);
    Route::resource('running_texts', RunningTextController::class);
    Route::resource('tahun-akademik', TahunAkademikController::class);
    Route::resource('kalender-akademik', KalenderAkademikController::class);
    Route::post('mahasiswa/import', [MahasiswaController::class, 'import'])->name('mahasiswa.import');
    Route::get('khusus/downloadformat', [KhususController::class, 'downloadFormat'])->name('khusus.downloadformat');
    Route::delete('khusus/delete-all', [KhususController::class, 'destroy'])->name('khusus.delete-all');
    Route::get('/kalender-akademik/download/pdf', [KalenderAkademikController::class, 'downloadPDF'])->name('kalender-akademik.download.pdf');
    Route::get('/kalender-akademik/download/excel', [KalenderAkademikController::class, 'downloadExcel'])->name('kalender-akademik.download.excel');



    
  
    // Route::get('/company-profiles', [CompanyProfileController::class, 'index']);
    // Route::post('/company-profiles', [CompanyProfileController::class, 'store']);
    // Route::delete('/company-profiles/{id}', [CompanyProfileController::class, 'destroy']);
    // Route::get('users/get', [UserController::class, 'getUsers'])->name('users.get');
    // Route::get('/profile', [ProfileController::class, 'edit']);
    // Route::get('/profile/update', [ProfileController::class, 'update']);
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/home', [TamuController::class, 'index']);
});
require __DIR__.'/auth.php';
