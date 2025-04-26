@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data API Urls</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="/">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="fas fa-fire"></i>
                </li>
                <li class="nav-item">
                    <a href="/backend/api-routes">Api Urls</a>
                </li>
            </ul>
        </div>
        
        <div class="alert alert-info">
            <strong>Catatan:</strong> Ini API untuk ke Frontend
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        
                    </div>
                    <div class="card-body">
                        <!-- Form Filter -->
                        
                        <div class="table-responsive">
                            <table  class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                <th>Method</th>
                <th>URI</th>
                <th>Route Name</th>
                <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($routes as $index => $route)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><span class="badge bg-primary">{{ $route['method'] }}</span></td>
                                            <td><code>http://127.0.0.1:8000/{{ $route['uri'] }}</code></td>
                                            <td>{{ $route['name'] ?? '-' }}</td>
                                            <td>{{ $route['action'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
