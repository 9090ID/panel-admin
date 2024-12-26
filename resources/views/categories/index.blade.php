@extends('layouts.app')

@section('content')
<div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Data Kategori Artikel</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="/users">
                    <i class="icon-user"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/categories">Kategori Artikel</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/categories">Kategori Artikel</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary mb-3 btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                        <i class="fas fa-plus"></i> Tambah Kategori
                        </button>
                      
                    </div>
                  </div>
                  <div class="card-body">
                    <!-- Modal -->
                    
                    <div class="table-responsive">
                      <!-- <table
                        id="users-table"
                        class="display table table-striped table-hover"
                      > -->
                      <table id="kategori-table" class="display table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>Nomor</th>
                            <th>Nama Kategori</th>
                            <th style="width: 10%">Action</th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<!-- Tambah Kategori -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createCategoryForm" action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Kategori</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="createCategoryForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCategoryForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="categoryId">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
        $(function() {
            $('#kategori-table').DataTable({
              responsive: true,
              scrollX: true,
              autoWidth: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }
                ]
            });
        });

        $(document).on('click', '.delete-btn', function() {
         let userId = $(this).data('id'); // ID user dari tombol
            let url = "{{ route('categories.destroy', ':id') }}".replace(':id', userId);

    if (confirm('Are you sure you want to delete this user?')) {
        $.ajax({
            url: url,
            type: 'DELETE', // Pastikan menggunakan metode DELETE
            data: {
        _token: $('meta[name="csrf-token"]').attr('content') // Ambil token dari meta tag
    },
            success: function(response) {
                alert(response.success);
                $('#kategori-table').DataTable().ajax.reload(); // Reload DataTables
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.error || 'Unknown error'));
            }
        });
    }
    });

    $(document).on('click', '.edit-category', function() {
    // Ambil data dari atribut tombol
    let id = $(this).data('id');
    let name = $(this).data('name');

    // Isi data ke dalam modal
    $('#categoryId').val(id);
    $('#categoryName').val(name);

    // Tampilkan modal
    $('#editCategoryModal').modal('show');
});

$('#editCategoryForm').on('submit', function(e) {
    e.preventDefault();

    let id = $('#categoryId').val();
    let name = $('#categoryName').val();
    let url = "/categories/" + id; // URL API untuk update kategori

    // Kirim data melalui AJAX
    $.ajax({
        url: url,
        type: 'PUT',
        data: {
            _token: '{{ csrf_token() }}',
            name: name
        },
        success: function(response) {
            $('#editCategoryModal').modal('hide'); // Tutup modal
            $('#kategori-table').DataTable().ajax.reload(); // Refresh tabel
            alert(response.success); // Tampilkan notifikasi
        },
        error: function(xhr) {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    });
});
    </script>



@endpush
