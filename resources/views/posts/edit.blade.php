@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <!-- Start breadcrumbs -->
        <div class="page-header">
            <h3 class="fw-bold mb-3">Edit Artikel/Berita</h3>
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
                        <div class="card-title">Edit Artikel</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <form action="{{ route('posts.update', $post->id) }}" id="edit-form" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Judul</label>
                                    <input type="text" name="title" class="form-control" id="judul" value="{{ $post->title }}" placeholder="Enter Judul" />
                                </div>

                                <div class="form-group">
                                    <label for="categories" class="form-label">Kategori</label>
                                    <select class="form-control" id="categories" name="categories[]" multiple required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ in_array($category->id, $post->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="author">Penulis/Author</label>
                                    <input type="text" name="author" class="form-control" id="author" value="{{ $post->author }}" placeholder="Enter Author" />
                                </div>

                                <div class="form-group">
                                    <label for="content" class="form-label">Konten</label>
                                    <textarea class="form-control" id="content" name="content" rows="5">{{ $post->content }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="image" class="form-label">Gambar Utama</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                                    @if($post->image)
                                        <div class="mt-2">
                                            <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" style="width: 150px; height: auto;">
                                        </div>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('posts.index') }}" class="btn btn-danger">Cancel</a>
                 
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
        placeholder: 'Edit konten Anda di sini...'
    });

    // Inisialisasi Select2 untuk kategori
    $('#categories').select2({
        placeholder: 'Pilih Kategori',
        allowClear: true
    });
});

$(document).on('submit', '#edit-form', function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'), // URL berasal dari form action
        type: $(this).attr('method'), // Method berasal dari form method
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            // SweetAlert untuk pesan sukses
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: response.message, // Pesan dari server
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            }).then(() => {
                // Redirect atau reload halaman
                window.location.href = response.redirect_url;
            });
        },
        error: function (xhr) {
            // SweetAlert untuk pesan error
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: xhr.responseJSON?.message || 'Terjadi kesalahan. Silakan coba lagi.',
                showConfirmButton: true
            });
        }
    });
});


</script>


@endpush
