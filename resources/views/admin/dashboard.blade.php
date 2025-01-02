@extends('layouts.app')

@section('content')


<div class="container">
  <div class="page-inner">
    <div
      class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div>
        <h3 class="fw-bold mb-3">Hy, {{ Auth::user()->name }}</h3>
        <h6 class="op-7 mb-2" id="greeting">
          <p>Sekarang jam: <strong id="current-time"></strong></p>
        </h6>
      </div>
      <!-- <div class="ms-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                <a href="#" class="btn btn-primary btn-round">Add Customer</a>
              </div> -->
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-primary bubble-shadow-small">
                  <i class="fas fa-graduation-cap"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Data Dosen/Pegawai</p>
                  <h4 class="card-title">{{$count_peg}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-info bubble-shadow-small">
                  <i class="fas fa-users"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Data Mahasiswa</p>
                  <h4 class="card-title">{{$count_mhs}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-success bubble-shadow-small">
                  <i class="fas fa-school"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Jumlah Fakultas</p>
                  <h4 class="card-title">{{$count_faku}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-info bubble-shadow-small">
                  <i class="fas fa-home"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Jumlah Prodi</p>
                  <h4 class="card-title">{{$count_prod}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-secondary bubble-shadow-small">
                  <i class="fas fa-bullhorn"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Jml Pengumuman</p>
                  <h4 class="card-title">{{$count_pengu}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-info bubble-shadow-small">
                  <i class="fas fa-file-alt"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Jml Berita</p>
                  <h4 class="card-title">{{$count_post}}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card card-round">
          <div class="card-header">
            <div class="card-head-row card-tools-still-right">
              <div class="card-title" style="color: red;">Identitas Lembaga</div>
              <div class="card-tools">
              </div>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center mb-0">
                <tr>
                  <th>Nama Lembaga</th>
                  <td>:</td>
                  <td>Insitut Islam Muaro Jambi</td>
                </tr>
                <tr>
                  <th>Kode PT</th>
                  <td>:</td>
                  <td>212137</td>
                </tr>
                <tr>
                  <th>Standar</th>
                  <td>:</td>
                  <td> SK PerBAN-PT No. 5 Tahun 2024</td>
                </tr>
                <tr>
                  <th>Status Akreditasi</th>
                  <td>:</td>
                  <td> Belum Terakreditasi</td>
                </tr>


              </table>
            </div>
          </div>
        </div>
      </div>


    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card card-round">
          <div class="card-header">
            <div class="card-head-row card-tools-still-right">
              <h4 class="card-title">Lokasi</h4>
              <div class="card-tools">
                <button
                  class="btn btn-icon btn-link btn-primary btn-xs">
                  <span class="fa fa-angle-down"></span>
                </button>
                <button
                  class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card">
                  <span class="fa fa-sync-alt"></span>
                </button>
                <button
                  class="btn btn-icon btn-link btn-primary btn-xs">
                  <span class="fa fa-times"></span>
                </button>
              </div>
            </div>
            <p class="card-category">
              Lokasi Kampus
            </p>
          </div>
          <div class="card-body">
            <div class="row">

              <div class="col-md-12">
                <div class="mapcontainer">
                  <div>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d249.26380504249002!2d103.58517710119487!3d-1.6213911311684974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e2589001fb07c6b%3A0x15db64cf25e52576!2sINISMA%20JAMBI!5e0!3m2!1sen!2sid!4v1735741266959!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                    >
                  </div>
                </div>
              </div>
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
  function updateTimeAndGreeting() {
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();

    // Format jam menjadi HH:mm:ss
    const formattedTime = [
      hours.toString().padStart(2, '0'),
      minutes.toString().padStart(2, '0'),
      seconds.toString().padStart(2, '0')
    ].join(':');

    // Menentukan ucapan berdasarkan jam
    let greeting = 'Selamat Malam';
    if (hours >= 0 && hours < 12) {
      greeting = 'Selamat Pagi';
    } else if (hours >= 12 && hours < 15) {
      greeting = 'Selamat Siang';
    } else if (hours >= 15 && hours < 18) {
      greeting = 'Selamat Sore';
    }

    // Update konten HTML
    document.getElementById('current-time').textContent = formattedTime;
    document.getElementById('greeting').textContent = greeting;
  }

  // Panggil fungsi saat halaman dimuat
  updateTimeAndGreeting();

  // Perbarui waktu setiap detik
  setInterval(updateTimeAndGreeting, 1000);
</script>
@endpush