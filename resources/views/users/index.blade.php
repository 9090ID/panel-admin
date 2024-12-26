@extends('layouts.app')

@section('content')
<div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Data Users</h3>
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
                  <a href="/users">Users</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/users">DataUsers</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
               
                      
                       <a href="{{ route('users.create') }}"><button
                        class="btn btn-primary btn-round ms-auto"
                        data-bs-toggle="modal"
                        data-bs-target="#addRowModal"
                      >
                        <i class="fa fa-plus"></i> Tambah Users</button></a> 
                      
                    </div>
                  </div>
                  <div class="card-body">
                    <!-- Modal -->
                    
                    <div class="table-responsive">
                      <!-- <table
                        id="users-table"
                        class="display table table-striped table-hover"
                      > -->
                      <table id="users-table" class="display table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>Nomor</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
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
@endsection

@push('scripts')
<script>
        $(function() {
            $('#users-table').DataTable({
              responsive: true,
              scrollX: true,
              autoWidth: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.show') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'role', name: 'role' },
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
    let url = "{{ route('users.destroy', ':id') }}".replace(':id', userId);

    if (confirm('Are you sure you want to delete this user?')) {
        $.ajax({
            url: url,
            type: 'DELETE', // Pastikan menggunakan metode DELETE
            data: {
        _token: $('meta[name="csrf-token"]').attr('content') // Ambil token dari meta tag
    },
            success: function(response) {
                alert(response.success);
                $('#users-table').DataTable().ajax.reload(); // Reload DataTables
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.error || 'Unknown error'));
            }
        });
    }
    });
    </script>



@endpush
