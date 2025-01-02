@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Pegawai</h3>
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
                    <a href="/pegawai">Pegawai</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary mb-3 btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#createPegawaiModal">
                                <i class="fas fa-plus"></i> Tambah Pegawai
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pegawai-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>NIP</th>
                                        <th>Jabatan</th>
                                        <th>Pendidikan Terakhir</th>
                                        <th>Foto</th>
                                        <th style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createPegawaiModal" tabindex="-1" aria-labelledby="createPegawaiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPegawaiModalLabel">Tambah Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createPegawaiForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="namadekan">Nama Lengkap dan Gelar</label>
                        <input type="text" name="namadekan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP/NIK/Nomor Induk Kampus</label>
                        <input type="text" name="nip" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jabatan_id">Jabatan</label>
                        <select name="jabatan_id" id="jabatan_id" class="form-control" required>
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach ($jabatan as $j)
                            <option value="{{ $j->id }}">{{ $j->namajabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lulusanterakhir">Pendidikan Terakhir</label>
                        <select name="lulusanterakhir" class="form-control" required>
                            <option value="" disabled selected>Pilih Pendidikan Terakhir</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA/MA">SMA/MA</option>
                            <option value="D1">D1</option>
                            <option value="D2">D2</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fotodekan">Foto Dekan</label>
                        <input type="file" name="fotodekan" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modals Edit Belum ada -->
<!-- Modal Edit Pegawai -->
<!-- Modal Edit Pegawai -->
<div class="modal fade" id="editPegawaiModal" tabindex="-1" aria-labelledby="editPegawaiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPegawaiModalLabel">Edit Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="editPegawaiForm" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Menggunakan metode PUT untuk update -->
                    <input type="hidden" id="edit-id" name="id">

                    <div class="form-group">
                        <label for="edit-namadekan">Nama Lengkap dan Gelar</label>
                        <input type="text" name="namadekan" id="edit-namadekan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-nip">NIP/NIK</label>
                        <input type="text" name="nip" id="edit-nip" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-jabatan">Jabatan</label>
                        <select name="jabatan_id" id="edit-jabatan" class="form-control" required>
                            <!-- Dropdown options will be populated dynamically -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="lulusanterakhir">Pendidikan Terakhir</label>
                        <select name="lulusanterakhir" id="edit-pendidikan" class="form-control" required>
                            <option value="" disabled selected>Pilih Pendidikan Terakhir</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA/MA">SMA/MA</option>
                            <option value="D1">D1</option>
                            <option value="D2">D2</option>
                            <option value="D3">D3</option>
                            <option value="D4">D4</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit-fotodekan">Foto Dekan</label>
                        <input type="file" name="fotodekan" id="edit-fotodekan" class="form-control">
                        <img id="edit-fotodekan-preview" src="" style="width: 100px; display: none;">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
        let table = $('#pegawai-table').DataTable({
            responsive: true,
            scrollX: true,
            autoWidth: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('kepeg-inisma.index') }}", // URL untuk mengambil data
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'namadekan',
                    name: 'namadekan'
                },
                {
                    data: 'nip',
                    name: 'nip'
                },
                {
                    data: 'jabatan', // Nama jabatan yang sudah di-relasi
                    name: 'jabatan',
                    render: function(data, type, row) {
                        return data ? data : '-'; // Menampilkan data jabatan atau '-' jika tidak ada
                    }
                },
                {
                    data: 'lulusanterakhir',
                    name: 'lulusanterakhir'
                },
                {
                    data: 'fotodekan',
                    name: 'fotodekan',

                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });




        // Delete functionality
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            let url = "{{ route('kepeg-inisma.destroy', ':id') }}".replace(':id', id);
            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            table.ajax.reload();
                            Swal.fire('Sukses!', response.message, 'success');
                        },
                        error: function() {
                            Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data.', 'error');
                        }
                    });
                }
            });
        });

        // Tambah functionality
        $('#createPegawaiForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah submit default form
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('kepeg-inisma.store') }}", // URL ke route store
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Tutup modal
                    $('#createPegawaiModal').modal('hide');

                    // Reload DataTable
                    $('#pegawai-table').DataTable().ajax.reload();

                    // Tampilkan pesan sukses
                    Swal.fire('Sukses!', 'Data pegawai berhasil ditambahkan.', 'success');
                },
                error: function(xhr, status, error) {
                    // Tampilkan pesan error
                    Swal.fire('Error!', 'Terjadi kesalahan saat menambahkan data.', 'error');
                }
            });
        });

        //edit belum selesai
        $(document).on('click', '.edit-pegawai', function() {
            let id = $(this).data('id');
            let url = "{{ route('kepeg-inisma.edit', ':id') }}".replace(':id', id);

            $.get(url, function(data) {
                if (data && data.pegawai) {
                    let pegawai = data.pegawai;
                    let jabatanSelect = $('#edit-jabatan'); // Dropdown Jabatan

                    // Masukkan data pegawai ke dalam form
                    $('#edit-id').val(pegawai.id); // Input hidden ID
                    $('#edit-namadekan').val(pegawai.namadekan);
                    $('#edit-nip').val(pegawai.nip);
                    $('#edit-pendidikan').val(pegawai.lulusanterakhir);

                    // Menampilkan foto pegawai jika ada
                    if (pegawai.fotodekan) {
                        $('#edit-fotodekan-preview').attr('src', '/' + pegawai.fotodekan).show();
                    } else {
                        $('#edit-fotodekan-preview').hide();
                    }

                    // Kosongkan dropdown jabatan sebelum menambahkan pilihan baru
                    jabatanSelect.empty();

                    // Tambahkan pilihan default "Pilih Jabatan"
                    jabatanSelect.append('<option value="">Pilih Jabatan</option>');

                    // Menambahkan data jabatan ke dropdown
                    if (data.jabatan.length > 0) {
                        data.jabatan.forEach(function(jabatan) {
                            let selected = pegawai.jabatan_id == jabatan.id ? 'selected' : ''; // Menandai jabatan yang dipilih
                            jabatanSelect.append('<option value="' + jabatan.id + '" ' + selected + '>' + jabatan.namajabatan + '</option>');
                        });
                    } else {
                        jabatanSelect.append('<option value="">No jabatan available</option>');
                    }

                    // Menampilkan modal edit
                    $('#editPegawaiModal').modal('show');
                } else {
                    alert('Data pegawai tidak ditemukan');
                }
            }).fail(function(xhr, status, error) {
                console.log('AJAX Error:', error);
                alert('Terjadi kesalahan saat memuat data.');
            });
        });
    // Fungsi Update ini mah
    $('#editPegawaiForm').on('submit', function(e) {
            e.preventDefault();
            let fakultasId = $('#edit-id').val();
            let url = "{{ route('kepeg-inisma.update', ':id') }}".replace(':id', fakultasId);
            let formData = new FormData(this);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#editPegawaiModal').modal('hide');
                    $('#pegawai-table').DataTable().ajax.reload();
                    Swal.fire('Success', 'Data Fakultas berhasil diubah', 'success');
                },
                error: function(response) {
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                }
            });
        });







    });
</script>
@endpush