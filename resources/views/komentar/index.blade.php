@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Komentar</h3>
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
                    <a href="/komentar">Komentar</a>
                </li>
            </ul>
        </div>
        
        <div class="alert alert-info">
            <strong>Catatan:</strong> Ini Komentar Artikel. 
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        
                    </div>
                    <div class="card-body">
                        <!-- Form Filter -->
                        
                        <div class="table-responsive">
                            <table id="commentsTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Post</th>
                                        <th>Tanggal Komentar</th>
                                        <th>Komentar</th>
                                        {{-- <th style="width: 10%">Action</th> --}}
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
    let table = $('#commentsTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('komentar.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {
                data: 'post_title',
                name: 'post_title',
                render: function(data) {
                    return '<div style="white-space: normal; word-wrap: break-word;">' + data + '</div>';
                }
            },
            { data: 'created_at', name: 'created_at' },
            { data: 'comment', name: 'comment' },
            
        ]
    });

    // Hapus Komentar
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        let url = "{{ route('komentar.destroy', ':id') }}".replace(':id', id);
        Swal.fire({
            title: 'Yakin ingin menghapus komentar ini?',
            text: 'Komentar yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire('Sukses!', response.message, 'success');
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus komentar.', 'error');
                    }
                });
            }
        });
    });
});
$(document).ready(function () {
    // Fungsi untuk memuat notifikasi terbaru
    function loadNotifications() {
        $.ajax({
            url: "/get-latest-comments", // Ganti dengan route yang mengambil komentar terbaru
            type: "GET",
            success: function (response) {
                let notifCount = response.length;
                $("#notifCount").text(notifCount); // Perbarui jumlah notifikasi
                if (notifCount > 0) {
                    $("#notifTitle").text(`Anda memiliki ${notifCount} komentar baru`);
                } else {
                    $("#notifTitle").text("Tidak ada notifikasi baru");
                }

                // Kosongkan dan isi ulang daftar notifikasi
                $("#notifContent").empty();
                response.forEach((notif) => {
                    let notifHtml = `
                        <a href="${notif.url}">
                            <div class="notif-icon notif-primary">
                                <i class="fa fa-comment"></i>
                            </div>
                            <div class="notif-content">
                                <span class="block">${notif.user} berkomentar: "${notif.comment}"</span>
                                <span class="time">${notif.time}</span>
                            </div>
                        </a>`;
                    $("#notifContent").append(notifHtml);
                });
            },
            error: function () {
                console.error("Gagal memuat notifikasi.");
            },
        });
    }

    // Panggil fungsi saat halaman dimuat
    loadNotifications();

    // Perbarui notifikasi setiap 30 detik
    setInterval(loadNotifications, 30000);
});

</script>
@endpush
