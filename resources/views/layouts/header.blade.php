<div class="main-panel">
    <div class="main-header">
        <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
                <a href="index.html" class="logo">
                    <img
                        src="{{asset('admin/img/kaiadmin/logo_light.svg')}}"
                        alt="navbar brand"
                        class="navbar-brand"
                        height="20" />
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="gg-menu-right"></i>
                    </button>
                    <button class="btn btn-toggle sidenav-toggler">
                        <i class="gg-menu-left"></i>
                    </button>
                </div>
                <button class="topbar-toggler more">
                    <i class="gg-more-vertical-alt"></i>
                </button>
            </div>
            <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">
                <nav
                    class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-search pe-1">
                                <i class="fa fa-search search-icon"></i>
                            </button>
                        </div>
                        <input
                            type="text"
                            placeholder="Search ..."
                            class="form-control" />
                    </div>
                </nav>

                <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                    <li
                        class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                        <a
                            class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown"
                            href="#"
                            role="button"
                            aria-expanded="false"
                            aria-haspopup="true">
                            <i class="fa fa-search"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-search animated fadeIn">
                            <form class="navbar-left navbar-form nav-search">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        placeholder="Search ..."
                                        class="form-control" />
                                </div>
                            </form>
                        </ul>
                    </li>
                    <li class="nav-item topbar-icon dropdown hidden-caret">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="messageDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-envelope"></i>
                        </a>
                        <ul
                            class="dropdown-menu messages-notif-box animated fadeIn"
                            aria-labelledby="messageDropdown">
                            <li>
                                <div
                                    class="dropdown-title d-flex justify-content-between align-items-center">
                                    Messages
                                    <a href="#" class="small">Mark all as read</a>
                                </div>
                            </li>
                            <li>
                                <div class="message-notif-scroll scrollbar-outer">
                                    <div class="notif-center">
                                        <a href="#">
                                            <div class="notif-img">
                                                <img
                                                    src="{{asset('admin/img/jm_denis.jpg')}}"
                                                    alt="Img Profile" />
                                            </div>
                                            <div class="notif-content">
                                                <span class="subject">Jimmy Denis</span>
                                                <span class="block"> How are you ? </span>
                                                <span class="time">5 minutes ago</span>
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="notif-img">
                                                <img
                                                    src="{{asset('admin/img/chadengle.jpg')}}"
                                                    alt="Img Profile" />
                                            </div>
                                            <div class="notif-content">
                                                <span class="subject">Chad</span>
                                                <span class="block"> Ok, Thanks ! </span>
                                                <span class="time">12 minutes ago</span>
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="notif-img">
                                                <img
                                                    src="{{asset('admin/img/mlane.jpg')}}"
                                                    alt="Img Profile" />
                                            </div>
                                            <div class="notif-content">
                                                <span class="subject">Jhon Doe</span>
                                                <span class="block">
                                                    Ready for the meeting today...
                                                </span>
                                                <span class="time">12 minutes ago</span>
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="notif-img">
                                                <img
                                                    src="{{asset('admin/img/talha.jpg')}}"
                                                    alt="Img Profile" />
                                            </div>
                                            <div class="notif-content">
                                                <span class="subject">Talha</span>
                                                <span class="block"> Hi, Apa Kabar ? </span>
                                                <span class="time">17 minutes ago</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a class="see-all" href="javascript:void(0);">See all messages<i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if (auth()->user()->role === 'admin' || 'master_admin')

   
                    <li class="nav-item topbar-icon dropdown hidden-caret">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="notifDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="notification" id="notifCount">0</span>
                        </a>
                        <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                            <li>
                                <div class="dropdown-title" id="notifTitle">
                                    Tidak ada notifikasi baru
                                </div>
                            </li>
                            <li>
                                <div class="notif-scroll scrollbar-outer">
                                    <div class="notif-center" id="notifContent">
                                        <!-- Konten notifikasi akan dimuat di sini -->
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a class="see-all" href="/komentar">Lihat semua notifikasi <i class="fa fa-angle-right"></i></a>
                            </li>
                        </ul>
                    </li>
                    @else
               
                    @endif
                    

                    <li class="nav-item topbar-user dropdown hidden-caret">
                        <a
                            class="dropdown-toggle profile-pic"
                            data-bs-toggle="dropdown"
                            href="#"
                            aria-expanded="false">
                            <div class="avatar-sm">
                                <img
                                    src="{{asset('admin/img/profile.jpg')}}"
                                    alt="..."
                                    class="avatar-img rounded-circle" />
                            </div>
                            <span class="profile-username">
                                <span class="op-7">Hi,</span>
                                <span class="fw-bold">{{ Auth::user()->name }}</span>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                                <li>
                                    <div class="user-box">
                                        <div class="avatar-lg">
                                            <img
                                                src="{{asset('admin/img/profile.jpg')}}"
                                                alt="image profile"
                                                class="avatar-img rounded" />
                                        </div>
                                        <div class="u-text">
                                            <h4>{{ Auth::user()->name }}</h4>
                                            <p class="text-muted">{{ Auth::user()->email }}</p>
                                            <a
                                                href="profile.html"
                                                class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">My Profile</a>
                                    <div class="dropdown-divider"></div>
                                    {{-- <a class="dropdown-item" href="#">Account Setting</a> --}}
                                    {{-- <div class="dropdown-divider"></div> --}}
                                    <a href="#" class="dropdown-item" id="logout-link" class="text-danger">Logout</a>

                                </li>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Navbar -->
    </div>
    @push('scripts')
    <script>
        document.getElementById('logout-link').addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah aksi default dari link

            // Membuat form logout secara dinamis
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("logout") }}'; // Arahkan ke route logout

            // Menambahkan CSRF token ke dalam form
            var csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            // Menambahkan form ke body dan mengirimkan form
            document.body.appendChild(form);
            form.submit(); // Kirimkan form untuk logout
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
                                <span class="block">${notif.name} berkomentar: "${notif.comment}"</span>
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