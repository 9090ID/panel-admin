@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Tambah Sambutan Pejabat</h3>
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
                    <a href="{{ route('sambutan-pejabat.index') }}">Sambutan Pejabat</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Tambah Sambutan</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('sambutan-pejabat.index') }}" class="btn btn-secondary btn-round ms-auto">
                                <i class="fa fa-arrow-left"></i> Kembali ke Daftar Sambutan
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="createSambutanForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="pegawai_id">Nama Pejabat</label>
                                <select name="pegawai_id" id="pegawai_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Pejabat</option>
                                    @foreach ($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}">{{ $pegawai->namadekan }}</option>
                                    @endforeach
                                </select>
                            </div>
                           
                            <div class="form-group">
                                <label for="jabatan_id">Jabatan</label>
                                <select name="jabatan_id" id="jabatan_id" class="form-control" required>
                                    <option value="" disabled selected>Pilih Jabatan</option>
                                    @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}">{{ $jabatan->namajabatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tglmulaimenjabat">Tanggal Mulai Menjabat</label>
                                <input type="date" name="tglmulaimenjabat" id="tglmulaimenjabat" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="akhirmenjabat">Tanggal Akhir Menjabat</label>
                                <input type="date" name="akhirjabatan" id="akhirjabatan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="riwayathidup">Riwayat Hidup</label>
                                <textarea name="riwayathidup" id="riwayathidup" class="form-control content" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="isisambutan">Isi Sambutan</label>
                                <textarea name="isisambutan" id="isisambutan" class="form-control content" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="fotopejabat">Foto Pejabat</label>
                                <input type="file" name="fotopejabat" id="fotopejabat" class="form-control">
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
        // Inisialisasi Summernote untuk editor teks
        $('.content').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ],
            placeholder: 'Tulis isi sambutan di sini...'
        });

        // Submit form menggunakan AJAX
        $('#createSambutanForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('sambutan-pejabat.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Sambutan Pejabat berhasil ditambahkan.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('sambutan-pejabat.index') }}";
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
@endpush