<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

use App\Http\Controllers\CompanyProfileController;
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
    Route::resource('/categories', CategoryController::class);
    Route::resource('/posts', PostController::class);
    Route::resource('/company-profiles', CompanyProfileController::class);
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
