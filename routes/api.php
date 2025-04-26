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
    Route::get('pimpinan', [ApiController::class, 'pimpinanIndex']);
    
    // API untuk menampilkan data fakultas
    Route::get('fakultas', [ApiController::class, 'fakultasIndex']);
    Route::get('fakultas/slug/{slug}', [ApiController::class, 'fakBySlug']);
    // API untuk menampilkan data prodi
    Route::get('prodi', [ApiController::class, 'prodiIndex']);
    
    Route::get('posts-home', [ApiController::class, 'postsIndex']);
    Route::get('sambutan', [ApiController::class, 'sambutanIndex']);
    Route::get('profile', [ApiController::class, 'profileIndex']);
    Route::get('pengumuman', [ApiController::class, 'pengumumanIndex']);
    Route::get('kalender-akademik', [ApiController::class, 'kalenderIndex']);
    Route::get('tahun-akademik', [ApiController::class, 'tahunIndex']);
    Route::get('download-pdf', [ApiController::class, 'downloadPdf']);

    Route::get('pengumuman/slug/{slug}', [ApiController::class, 'showBySlugpengumuman']);
    Route::get('pengumumanall', [ApiController::class, 'pengumumanallIndex']);
    Route::post('comments', [ApiController::class, 'store']);
    Route::get('/posts/{slug}/comments', [ApiController::class, 'getComment']);
    Route::post('/posts/{id}/increment-views', [ApiController::class, 'incrementViews']);
    Route::get('/posts/most-visited', [ApiController::class, 'mostVisited']);

    Route::get('logo', [ApiController::class, 'logoIndex']);
    Route::get('posts',[ApiController::class, 'postsAllIndex']);
    Route::get('posts/slug/{slug}', [ApiController::class, 'showBySlug']);
    Route::get('mahasiswa/count', [ApiController::class, 'hitungMahasiswa']);
    Route::get('dosen/count', [ApiController::class, 'hitungDosen']);
    Route::get('fakultas/count', [ApiController::class, 'hitungFakultas']);
    Route::get('prodi/count', [ApiController::class, 'hitungProdi']);
    Route::get('videos', [ApiController::class, 'videoIndex']);
    Route::get('running', [ApiController::class, 'runningIndex']);
    // Route::get('posts/{slug}', [ApiController::class, 'show']);
    Route::get('/route-list', function () {
    // Dapatkan semua route
    $routes = collect(Route::getRoutes())
        ->filter(fn ($route) => str_contains($route->uri, 'api')) // Filter hanya untuk path 'api'
        ->map(function ($route) {
            return [
                'method' => $route->methods()[0],
                'uri' => $route->uri,
                'name' => $route->getName(),
                'action' => $route->getActionName(),
                'middleware' => $route->gatherMiddleware(),
            ];
        });

    return response()->json($routes);
});
});
