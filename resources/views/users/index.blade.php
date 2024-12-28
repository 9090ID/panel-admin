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

        <!-- modal ubah password -->
         <!-- Modal Ubah Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    @csrf
                    <input type="hidden" id="user-id" name="user_id">
                    <div class="form-group">
                        <label for="new-password">Password Baru</label>
                        <input type="password" class="form-control" id="new-password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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

    $(document).on('click', '.change-password-btn', function() {
    let userId = $(this).data('id');
    $('#user-id').val(userId); // Set ID user ke dalam field tersembunyi
});

// Submit form ubah password
$('#changePasswordForm').on('submit', function(e) {
    e.preventDefault();

    let userId = $('#user-id').val(); // Ambil ID user dari input tersembunyi
    let newPassword = $('#new-password').val();
    let confirmPassword = $('#confirm-password').val();

    // Validasi agar password baru dan konfirmasi password cocok
    if (newPassword !== confirmPassword) {
        alert('Password tidak cocok!');
        return;
    }

    $.ajax({
        url: `/users/${userId}/change-password`, // Ganti dengan URL sesuai rute Anda
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            password: newPassword,
        },
        success: function(response) {
            if (response.success) {
                alert('Password berhasil diubah!');
                $('#changePasswordModal').modal('hide'); // Tutup modal
            } else {
                alert('Terjadi kesalahan: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('Terjadi kesalahan: ' + (xhr.responseJSON?.message || 'Unknown error'));
        }
    });
});
    </script>



@endpush
