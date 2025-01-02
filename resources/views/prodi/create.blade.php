@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Tambah Program Studi</h3>
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
                    <a href="/prodi">Program Studi</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Tambah Prodi</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('prodi-inisma.index') }}" class="btn btn-secondary btn-round ms-auto">
                                <i class="fa fa-arrow-left"></i> Kembali ke Daftar Prodi
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                    <form id="createProdiForm" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="namaprodi">Nama Prodi</label>
                                <input type="text" name="namaprodi" id="namaprodi" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="kodeprodi">Kode Prodi</label>
                                <input type="text" name="kodeprodi" id="kodeprodi" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="jenjang">Jenjang</label>
                                <select name="jenjang" id="jenjang" class="form-control" required>
                                    <option value="" disabled selected>Pilih Jenjang</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="akreditasi">Akreditasi Prodi</label>
                                <select name="akreditasi" id="akreditasi" class="form-control" required>
                                    <option value="" disabled selected>Pilih Akreditasi</option>
                                    <option value="Unggul">Unggul</option>
                                    <option value="Baik Sekali">Baik Sekali</option>
                                    <option value="Baik">Baik</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="visi">Visi Prodi</label>
                                <input name="visi" id="visi" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="misi">Misi Prodi</label>
                                <textarea name="misi" id="misi" class="form-control content1" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="deskripsisingkat">Deskripsi Singkat Prodi</label>
                                <textarea name="deskripsisingkat" id="deskripsisingkat" class="form-control content" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="fakultas_id">Fakultas</label>
                                <select name="fakultas_id" id="fakultas_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Fakultas</option>
                                    @foreach ($fakultas as $f)
                                    <option value="{{ $f->id }}">{{ $f->namafakultas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ketua_prodi_id">Nama Ketua Prodi</label>
                                <select name="ketua_prodi_id" id="ketua_prodi_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Ketua Prodi</option>
                                    @foreach ($pegawais as $p)
                                    <option value="{{ $p->id }}">{{ $p->namadekan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
        $('.content').summernote({
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
        $('.content1').summernote({
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
        // Submit form menggunakan AJAX
        $('#createProdiForm').on('submit', function(e) {
            e.preventDefault();  // Mencegah submit biasa

            var formData = new FormData(this);  // Ambil data dari form

            $.ajax({
                url: "{{ route('prodi-inisma.store') }}",  // URL untuk route store
                type: "POST",  // Metode pengiriman POST
                data: formData,  // Data dari form
                processData: false,  // Jangan memproses data secara otomatis
                contentType: false,  // Jangan set konten tipe
                success: function(response) {
                    // Jika berhasil, tampilkan SweetAlert
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Program Studi berhasil ditambahkan.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('prodi-inisma.index') }}";  // Redirect ke halaman index
                    });
                },
                error: function(xhr, status, error) {
                    // Jika gagal, tampilkan SweetAlert
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menambahkan data.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>



@endpush
