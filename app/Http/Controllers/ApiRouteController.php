<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
class ApiRouteController extends Controller
{
    public function index()
    {
        // Mendapatkan daftar semua rute
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            return strpos($route->uri, 'api/') === 0; // Filter hanya rute API
        })->map(function ($route) {
            return [
                'method' => implode('|', $route->methods()),
                'uri' => $route->uri,
                'name' => $route->getName(),
                'action' => $route->getActionName(),
            ];
        });

        return view('admin.api_routes', compact('routes'));
    }
}
