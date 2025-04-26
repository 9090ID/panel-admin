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
            @if (auth()->user()->role === 'master_admin')
              @include('layouts.menu.menu_master')
            @elseif (auth()->user()->role === 'admin')
              @include('layouts.menu.menu_admin')
            @elseif (auth()->user()->role === 'user')
              @include('layouts.menu.menu_users')
            @endif
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