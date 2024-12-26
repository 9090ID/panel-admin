@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <!-- Start breadcrumbs -->
        <div class="page-header">
            <h3 class="fw-bold mb-3">Tambah Artikel/Berita</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="/posts">
                        <i class="icon-user"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="/posts">Artikel</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="/posts">Data Artikel</a>
                </li>
            </ul>
        </div>
        <!-- End breadcrumbs -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Tambah Artikel</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <form action="{{ route('posts.store') }}" id="sample-form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Judul</label>
                                    <input type="text" name="title" class="form-control" id="judul" placeholder="Enter Judul" />
                                </div>

                                <div class="form-group">
                                <label for="categories" class="form-label">Kategori</label>
                                <select class="form-control" id="categories" name="categories[]" multiple required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                </div>

                                <div class="form-group">
                                    <label for="author">Penulis/Author</label>
                                    <input type="text" name="author" class="form-control" id="author" placeholder="Enter Author" />
                                </div>

                                <div class="form-group">
                                    <label for="content" class="form-label">Konten</label>
                                    <textarea class="form-control" id="content" name="content" rows="5" ></textarea>
                                </div>

                                <div class="form-group">
                                <label for="image" class="form-label">Gambar Utama</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                </div>

                                <button type="submit" class="btn btn-primary" >Submit</button>
                                <button class="btn btn-danger">Cancel</button>
                 
                    </div>
                    </form>
                </div>
            </div>
        </div>

</div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
        $('#content').summernote({
            height: 300, // Tinggi editor
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            placeholder: 'Tulis konten Anda di sini...'
        });
    });

    

    // Inisialisasi Select2 untuk kategori
    $(document).ready(function() {
        $('#categories').select2({
            placeholder: 'Pilih Kategori',
            allowClear: true
        });
    });
</script>

@endpush

