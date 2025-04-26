@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <!-- Start breadcrumbs -->
        <div class="page-header">
            <h3 class="fw-bold mb-3">Edit Users</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="/pengguna">
                        <i class="icon-user"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="/pengguna">Users</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="/pengguna">DataUsers</a>
                </li>
            </ul>
        </div>
        <!-- End breadcrumbs -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Edit User</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-8">
                            <form action="{{ route('pengguna.update', $user->id) }}" method="POST">
                                    @csrf
		                            @method('put')
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" />
                                </div>
                                <div class="form-group">
                                    <label for="email2">Email</label>
                                    <input type="text" name="email" class="form-control" id="email2" value="{{ old('email', $user->email) }}" />
                                    @error('email')
                                    <span style="color:red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input name="password" type="password" class="form-control" id="password" placeholder="Password" value="{{$user->password}}" />
                                    @error('password')
                                        <span style="color:red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                <label>Role Users</label>
                                    <select class="form-control"id="formG" name="role">
                                    <option value="{{$user->role }}">{{$user->role}}</option>
                                    @if($user->role != 'admin')
                                    <option value="admin">Admin</option>
                                    @else
                                    ($user->role != 'user')
                                    <option value="user">User</option>
                                    @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    <div class="card-action">
                        <button class="btn btn-success" type="submit">Submit</button>
                        <button class="btn btn-danger">Cancel</button>
                    </div>
                 
                    </div>
                    </form>
                </div>
            </div>
        </div>

</div>
</div>
@endsection

