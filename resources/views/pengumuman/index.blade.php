@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Pengumuman</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('pengumuman.index') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengumuman.index') }}">Pengumuman</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengumuman.index') }}">Data Pengumuman</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('pengumuman.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i> Tambah Pengumuman
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pengumuman-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Author</th>
                                        <th>Tanggal Publish</th>
                                        <th style="width: 5%">Action</th>
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
   $(document).ready(function() {
    $('#pengumuman-table').DataTable({
            responsive: true,
            // scrollX: true,
            // autoWidth: true,
            processing: true,
            serverSide: true,
        ajax: "{{ route('pengumuman.index') }}",  // Pastikan rute ini benar
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {
                data: 'judul',
                name: 'judul',
                render: function(data) {
                    return '<div style="white-space: normal; word-wrap: break-word;">' + data + '</div>';
                }
            },
            { data: 'author', name: 'author' },
          
            { data: 'tanggalpublish', name: 'tanggalpublish' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        error: function(xhr, error, thrown) {
            console.error('Error:', error, thrown);
        }
    });
});

        $(document).on('click', '.delete-btn', function() {
            const pengumumanId = $(this).data('id');
            const url = "{{ route('pengumuman.destroy', ':id') }}".replace(':id', pengumumanId);

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Berhasil!', response.success, 'success');
                            $('#pengumuman-table').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', xhr.responseJSON?.error || 'Terjadi kesalahan.', 'error');
                        }
                    });
                }
            });
        });
    
</script>
@endpush
