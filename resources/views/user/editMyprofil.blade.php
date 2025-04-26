@extends('templatinguser.layout')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Dashboard</h3>
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
                    <a href="/profile">Welcome, {{ Auth::user()->name }}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container row">
        <div class="col-md-12">
            <div class="card container">
                <div class="container mt-5">
                    <h1>Edit Profil</h1>
                    <div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Step 1</div>
                    </div>
                    <form id="multiStepForm" action="{{ route('mhs.update', $mahasiswa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Step 1: Informasi Pribadi -->
                        <div class="step" id="step1">
                            <h3>Step 1: Informasi Pribadi</h3>
                            <div class="mb-3">
                                <label for="name" class="form-label">Upload Image</label>
                                <input type="file" class="form-control" id="foto" value="{{ $mahasiswa->nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" value="{{ $mahasiswa->nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" value="{{ $mahasiswa->nim }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="prodi" class="form-label">Program Studi</label>
                                <input type="text" class="form-control" id="prodi" value="{{ $mahasiswa->prodi->namaprodi ?? 'Tidak ada' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="fakultas" class="form-label">Fakultas</label>
                                <input type="text" class="form-control" id="fakultas" value="{{ $mahasiswa->prodi->fakultas->namafakultas ?? 'Tidak ada' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="text" class="form-control" id="no_hp" value="{{ $mahasiswa->no_hp }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ $mahasiswa->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" id="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="angkatan" class="form-label">Angkatan</label>
                                <input type="text" readonly class="form-control" id="angkatan" value="{{ $mahasiswa->angkatan }}" required>
                            </div>
                            <button type="button" class="btn btn-primary nextBtn mb-4">Next</button>
                        </div>
                
                        <!-- Step 2: Alamat -->
                        <div class="step" id="step2" style="display:none;">
                            <h3>Step 2: Al amat</h3>
                            <div class="mb-3">
                                <label for="rt_rw" class="form-label">RT/RW</label>
                                <input type="text" class="form-control" id="rt_rw" required>
                            </div>
                            <div class="mb-3">
                                <label for="kelurahan" class="form-label">Kelurahan</label>
                                <input type="text" class="form-control" id="kelurahan" required>
                            </div>
                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" required>
                            </div>
                            <div class="mb-3">
                                <label for="kota_kab" class="form-label">Kota/Kabupaten</label>
                                <input type="text" class="form-control" id="kota_kab" required>
                            </div>
                            <div class="mb-3">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <input type="text" class="form-control" id="provinsi" required>
                            </div>
                            <div class="mb-3">
                                <label for="kode_pos" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" id="kode_pos" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat_lengkap" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="alamat_tinggal_sekarang" class="form-label">Alamat Tinggal Sekarang</label>
                                <textarea class="form-control" id="alamat_tinggal_sekarang" required></textarea>
                            </div>
                            <button type="button" class="btn btn-secondary prevBtn mb-4">Previous</button>
                            <button type="button" class="btn btn-primary nextBtn mb-4">Next</button>
                        </div>
                
                        <!-- Step 3: Data Pribadi Orangtua -->
                        <div class="step" id="step3" style="display:none;">
                            <h3>Step 3: Data Pribadi Orangtua</h3>
                            <div class="mb-3">
                                <label for="nama_ortu" class="form-label">Nama Orangtua</label>
                                <input type="text" class="form-control" id="nama_ortu" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp_ortu" class="form-label">No HP Orangtua</label>
                                <input type="text" class="form-control" id="no_hp_ortu" required>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan_ortu" class="form-label">Pekerjaan Orangtua</label>
                                <input type="text" class="form-control" id="pekerjaan_ortu" required>
                            </div>
                            <button type="button" class="btn btn-secondary prevBtn mb-4">Previous</button>
                            <button type="submit" class="btn btn-success mb-4">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let currentStep = 1;

        // Load data from local storage
        const fields = ['name', 'nim', 'prodi', 'fakultas', 'no_hp', 'email', 'jenis_kelamin', 'angkatan', 'rt_rw', 'kelurahan', 'kecamatan', 'kota_kab', 'provinsi', 'kode_pos', 'alamat_lengkap', 'alamat_tinggal_sekarang', 'nama_ortu', 'no_hp_ortu', 'pekerjaan_ortu'];
        fields.forEach(field => {
            if (localStorage.getItem(field)) {
                $(`#${field}`).val(localStorage.getItem(field));
            }
        });

        $('.nextBtn').click(function() {
            console.log('Current Step:', currentStep);
            if (currentStep < 3) {
                // Save data to local storage
                fields.forEach(field => {
                    localStorage.setItem(field, $(`#${field}`).val());
                });

                $(`#step${currentStep}`).hide();
                currentStep++;
                $(`#step${currentStep}`).show();
                updateProgressBar();
            }
        });

        $('.prevBtn').click(function() {
            if (currentStep > 1) {
                $(`#step${currentStep}`).hide();
                currentStep--;
                $(`#step${currentStep}`).show();
                updateProgressBar();
            }
        });

        $('#multiStepForm').submit(function(e) {
            e.preventDefault();
            alert('Form submitted successfully!');
            // Clear local storage after submission
            fields.forEach(field => {
                localStorage.removeItem(field);
            });
        });

        function updateProgressBar() {
            const progressPercentage = (currentStep / 3) * 100;
            $('.progress-bar').css('width', progressPercentage + '%').attr('aria-valuenow', progressPercentage).text('Step ' + currentStep);
        }
    });
</script>
@endpush