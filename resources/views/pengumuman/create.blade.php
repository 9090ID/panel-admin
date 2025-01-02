@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Tambah Pengumuman</h3>
        </div>
        <form id="pengumumanForm">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" id="author" name="author" placeholder="Masukkan Author" value="Admin" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="isipengumuman">Isi Pengumuman</label>
                        <textarea id="isipengumuman" name="isipengumuman" class="form-control summernote" required></textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="tanggalpublish">Tanggal Publish</label>
                        <input type="date" class="form-control" id="tanggalpublish" name="tanggalpublish" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="categories">Kategori</label>
                        <select id="categories" name="categories[]" class="form-control select2" multiple="multiple" required>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="file">File (PDF)</label>
                        <input type="file" id="file" name="file" class="form-control" accept=".pdf">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="published">Published</option>
                            <option value="drafted">Drafted</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi Summernote
        $('.summernote').summernote({
            height: 200,
        });

        // Inisialisasi Select2
        $('.select2').select2({
            placeholder: 'Pilih kategori',
        });

        // AJAX Submit Form
        $('#pengumumanForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('pengumuman.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire('Berhasil!', response.success, 'success').then(() => {
                        window.location.href = "{{ route('pengumuman.index') }}";
                    });
                },
                error: function(xhr) {
                    let errorMsg = xhr.responseJSON?.message || 'Terjadi kesalahan.';
                    Swal.fire('Gagal!', errorMsg, 'error');
                }
            });
        });
    });
</script>
@endpush