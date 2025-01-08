<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img
                src="{{asset('admin/img/kaiadmin/logo_light.svg')}}"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              />
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
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <!-- <li class="nav-item active">
                <a
                  data-bs-toggle="collapse"
                  href="#dashboard"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="dashboard">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="../demo1/index.html">
                        <span class="sub-item">Dashboard 1</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li> -->
              <li class="nav-item">
                <a href="/admin/dashboard">
                  <i class="fas fa-desktop"></i>
                  <p>Dashboard</p>
                
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Data Publish</h4>
              </li>

              <li class="nav-item">
                <a href="/posts">
                  <i class="fas fa-book"></i>
                  <p>Post Artikel/Berita</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/pengumuman">
                  <i class="fas fa-bullhorn"></i>
                  <p>Post Pengumuman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/running_texts">
                  <i class="fas fa-bullhorn"></i>
                  <p>Post Running Teks</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/videos">
                  <i class="fas fa-desktop"></i>
                  <p>Post Video</p>
                </a>
              </li>

              

              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Data Kampus</h4>
              </li>
              <li class="nav-item">
                <a href="/company-profiles">
                  <i class="fas fa-school"></i>
                  <p>Profil Kampus</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/fakultas-inisma">
                  <i class="fas fa-home"></i>
                  <p>Data Fakultas</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="/prodi-inisma">
                  <i class="fas fa-graduation-cap"></i>
                  <p>Data Program Studi</p>
                </a>
              </li>
              

              <li class="nav-item">
                <a href="/kepeg-inisma">
                  <i class="fas fa-users"></i>
                  <p>Data Dosen/Pegawai</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/mahasiswa">
                  <i class="fas fa-users"></i>
                  <p>Data Mahasiswa</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/kalender-akademik">
                  <i class="fas fa-file"></i>
                  <p>Data Kalender Akademik</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/sambutan-pejabat">
                  <i class="fas fa-user-graduate"></i>
                  <p>Data Sambutan Pejabat</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Data Referensi</h4>
              </li>
              <li class="nav-item">
                <a href="/tahun-akademik">
                  <i class="far fa-file"></i>
                  <p>Data Ref. Tahun Akademik</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/jabatan">
                  <i class="far fa-address-card"></i>
                  <p>Data Ref. Jabatan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/categories">
                  <i class="fas fa-file"></i>
                  <p>Data Kat Berita/Artikel</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="/users">
                  <i class="fas fa-users"></i>
                  <p>Users</p>
                </a>
              </li>
              

              <!-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                  <i class="fas fa-layer-group"></i>
                  <p>Base</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="components/avatars.html">
                        <span class="sub-item">Avatars</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/buttons.html">
                        <span class="sub-item">Buttons</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/gridsystem.html">
                        <span class="sub-item">Grid System</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/panels.html">
                        <span class="sub-item">Panels</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/notifications.html">
                        <span class="sub-item">Notifications</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/sweetalert.html">
                        <span class="sub-item">Sweet Alert</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/font-awesome-icons.html">
                        <span class="sub-item">Font Awesome Icons</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/simple-line-icons.html">
                        <span class="sub-item">Simple Line Icons</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/typography.html">
                        <span class="sub-item">Typography</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li> -->
              <!-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLayouts">
                  <i class="fas fa-th-list"></i>
                  <p>Sidebar Layouts</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="sidebarLayouts">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="sidebar-style-2.html">
                        <span class="sub-item">Sidebar Style 2</span>
                      </a>
                    </li>
                    <li>
                      <a href="icon-menu.html">
                        <span class="sub-item">Icon Menu</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#forms">
                  <i class="fas fa-pen-square"></i>
                  <p>Forms</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="forms">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="forms/forms.html">
                        <span class="sub-item">Basic Form</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#tables">
                  <i class="fas fa-table"></i>
                  <p>Tables</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="tables">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="tables/tables.html">
                        <span class="sub-item">Basic Table</span>
                      </a>
                    </li>
                    <li>
                      <a href="tables/datatables.html">
                        <span class="sub-item">Datatables</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#maps">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>Maps</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="maps">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="maps/googlemaps.html">
                        <span class="sub-item">Google Maps</span>
                      </a>
                    </li>
                    <li>
                      <a href="maps/jsvectormap.html">
                        <span class="sub-item">Jsvectormap</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#charts">
                  <i class="far fa-chart-bar"></i>
                  <p>Charts</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="charts">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="charts/charts.html">
                        <span class="sub-item">Chart Js</span>
                      </a>
                    </li>
                    <li>
                      <a href="charts/sparkline.html">
                        <span class="sub-item">Sparkline</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a href="widgets.html">
                  <i class="fas fa-desktop"></i>
                  <p>Widgets</p>
                  <span class="badge badge-success">4</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../documentation/index.html">
                  <i class="fas fa-file"></i>
                  <p>Documentation</p>
                  <span class="badge badge-secondary">1</span>
                </a>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#submenu">
                  <i class="fas fa-bars"></i>
                  <p>Menu Levels</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="submenu">
                  <ul class="nav nav-collapse">
                    <li>
                      <a data-bs-toggle="collapse" href="#subnav1">
                        <span class="sub-item">Level 1</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnav1">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li> -->
                      <!-- <a data-bs-toggle="collapse" href="#subnav2">
                        <span class="sub-item">Level 1</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnav2">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Level 1</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul> -->
          </div>
        </div>
      </div>
      <!-- End Sidebar -->
      <script>
  // JavaScript untuk menambahkan class 'active' pada menu yang sedang aktif
  document.addEventListener("DOMContentLoaded", function () {
    const currentPath = window.location.pathname; // Dapatkan path URL saat ini
    const menuItems = document.querySelectorAll(".sidebar .nav-item a");

    menuItems.forEach((menuItem) => {
      // Jika href sama dengan path saat ini, tambahkan class 'active'
      if (menuItem.getAttribute("href") === currentPath) {
        menuItem.parentElement.classList.add("active");
      }
    });

    // Tambahkan event listener untuk klik pada menu (opsional)
    menuItems.forEach((menuItem) => {
      menuItem.addEventListener("click", () => {
        menuItems.forEach((item) =>
          item.parentElement.classList.remove("active")
        );
        menuItem.parentElement.classList.add("active");
      });
    });
  });
</script>