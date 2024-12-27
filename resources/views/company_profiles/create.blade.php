@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Tambah Company Profile</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('company-profiles.index') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('company-profiles.index') }}">Company Profile</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('company-profiles.create') }}">Tambah Profile</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4>Form Tambah Company Profile</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="companyProfileForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Perusahaan</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="vision">Visi</label>
                                <textarea class="form-control" id="vision" name="vision" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="mission">Misi</label>
                                <textarea class="form-control" id="mission" name="mission" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="history">Sejarah</label>
                                <textarea class="form-control" id="content" name="history" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="description">Latar Belakang Perusahaan</label>
                                <textarea class="form-control" id="content1" name="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="founded_year">Tahun Berdiri</label>
                                <input type="date" class="form-control" id="founded_year" name="founded_year" required>
                            </div>
                            <div class="form-group">
                                <label for="structure_image">Gambar Struktur</label>
                                <input type="file" class="form-control" id="structure_image" name="structure_image">
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo Perusahaan</label>
                                <input type="file" class="form-control" id="logo" name="logo">
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        </form>
                    </div>
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

    $(document).ready(function() {
        $('#content1').summernote({
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

    // Submit form dengan AJAX
    $('#companyProfileForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('company-profiles.store') }}", // Ganti dengan rute yang sesuai
            type: 'POST',
            data: formData,
            processData: false, // Jangan proses data
            contentType: false, // Jangan set content type
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Company profile has been added successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "{{ route('company-profiles.index') }}"; // Redirect ke halaman index
                });
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                $.each(errors, function(key, value) {
                    errorMessage += value + '<br>';
                });

                Swal.fire({
                    title: 'Error!',
                    html: errorMessage,
                    icon: 'error'
                });
            }
        });
    });
</script>
@endpush
