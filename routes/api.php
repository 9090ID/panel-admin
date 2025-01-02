<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('api')->group(function() {
    // API untuk menampilkan data mahasiswa
    Route::get('mahasiswa', [ApiController::class, 'mahasiswaIndex']);
    
    // API untuk menampilkan data fakultas
    Route::get('fakultas', [ApiController::class, 'fakultasIndex']);
    
    // API untuk menampilkan data prodi
    Route::get('prodi', [ApiController::class, 'prodiIndex']);
    
    Route::get('posts', [ApiController::class, 'postsIndex']);
});
