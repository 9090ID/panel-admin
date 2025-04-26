@extends('templatinguser.layout')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Dashboard</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="/">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Welcome, {{ Auth::user()->name }}</a>
                </li>
            </ul>
            
        </div>
        <div class="container">
            <div class="row">
                Ini Halaman Dashboar Users
            </div>
        </div>

    </div>
</div>
        
 
@endsection
