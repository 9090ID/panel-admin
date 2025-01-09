@extends('layouts.app')

@section('content')


<div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Data Artikel</h3>
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
                  <a href="/categories"> Artikel</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/categories">Artikel</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                    <a href="{{ route('posts.create') }}" class="btn btn-primary btn-round ms-auto">
                        <i class="fa fa-plus"></i> Tambah Artikel</a> 
                      
                    </div>
                  </div>
                  <div class="card-body">
                    <!-- Modal -->
                    
                    <div class="table-responsive">
                      <!-- <table
                        id="users-table"
                        class="display table table-striped table-hover"
                      > -->
                      <table id="posts-table" class="display table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Kategori Berita</th>
                            <th style="width: 10%">Image</th>
                            <th style="width: 10%">Aksi</th>
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
 


@endsection

@push('scripts')
<script>
 $(function() {
    $('#posts-table').DataTable({
        responsive: true,
        // scrollX: true,
        autoWidth: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('posts.index') }}", // URL menuju controller
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {
                data: 'title',
                name: 'title',
                render: function(data) {
                    return '<div style="white-space: normal; word-wrap: break-word;">' + data + '</div>';
                }
            },
            {
                data: 'author',
                name: 'author',
                render: function(data) {
                    return '<div style="white-space: normal; word-wrap: break-word;">' + data + '</div>';
                }
            },
            {
                data: 'categories',
                name: 'categories',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return '<div style="white-space: normal; word-wrap: break-word;">' + data + '</div>';
                }
            },
            { data: 'image', name: 'image', orderable: false, searchable: false }, // Kolom untuk foto
            { data: 'action', name: 'action', orderable: false, searchable: false } // Kolom aksi
        ]
    });
});;

$(document).on('click', '.delete-post', function () {
    var postId = $(this).data('id');
    var url = "{{ route('posts.destroy', ':id') }}".replace(':id', postId);

    // Menampilkan konfirmasi dengan SweetAlert
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Melakukan AJAX delete
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        // Menampilkan notifikasi SweetAlert berhasil
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            // Reload DataTable setelah berhasil menghapus
                            $('#posts-table').DataTable().ajax.reload();
                        });
                    } else {
                        // Menampilkan notifikasi gagal
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan: ' + response.message,
                        });
                    }
                },
                error: function (xhr) {
                    // Menampilkan notifikasi error saat gagal
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Terjadi kesalahan: ' + xhr.responseJSON.message,
                    });
                }
            });
        }
    });
});


    </script>



@endpush
