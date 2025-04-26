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
    <div class="row">
        <div class="col-md-12">
            <div class="container">
              <div class="d-flex np-wrap tombol text-align-center mb-4">
                
                <a href="{{ route('mhs.editMyprofil', $mahasiswa->id) }}"><button class="btn btn-danger">Ubah Profil</button></a>
                              
              </div>
                <div class="main-body">
                      <div class="row gutters-sm">
                        <div class="col-md-4 mb-3">
                          <div class="card">
                            <div class="card-body">
                              <div class="d-flex flex-column align-items-center text-center">
                                <img  src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" width="150">
                                <div class="mt-3">
                                  <h4>{{ $mahasiswa->nama }}</h4>
                                  <h3>{{ $mahasiswa->nim }}</h3>
                                  
                                  {{-- <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p> --}}
                                  {{-- <button class="btn btn-outline-primary">Message</button> --}}
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="card mt-3">
                            <h3 class="d-flex mx-3 py-2 mb-2 justify-content-center align-items-center flex-wrap">Akun Media Sosial</h3>
                            <ul class="list-group list-group-flush">
                              {{-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Website</h6>
                                <span class="text-secondary">https://bootdey.com</span>
                              </li> --}}
                              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>Github</h6>
                                <span class="text-secondary">bootdey</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>Twitter</h6>
                                <span class="text-secondary">@bootdey</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>Instagram</h6>
                                <span class="text-secondary">bootdey</span>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>Facebook</h6>
                                <span class="text-secondary">bootdey</span>
                              </li>
                            </ul>
                          </div>
                        </div>
                        <div class="col-md-8">
                          <div class="card mb-3">
                            <div class="card-body">
                              <div class="row">
                                <h3 class="d-flex mx-3 py-2 mb-2 justify-content-center align-items-center flex-wrap text-danger">Biodata Diri</h3>
                                <hr>  
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Nama Lengkap</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $mahasiswa->nama }}
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">NIM</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $mahasiswa->nim }}
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Prodi</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  {{ $mahasiswa->prodi->namaprodi ?? 'Tidak ada' }}
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Fakultas</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  {{ $mahasiswa->prodi->fakultas->namafakultas ?? 'Tidak ada' }}
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $mahasiswa->email }}
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Phone/Whatsapp</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $mahasiswa->no_hp }}
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Mobile</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                  (320) 380-4539
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <h6 class="mb-0">Alamat</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $mahasiswa->alamat }}
                                </div>
                              </div>
                              <hr>
                              {{-- <div class="row">
                                <div class="col-sm-12">
                                  <a class="btn btn-info " target="__blank" href="https://www.bootdey.com/snippets/view/profile-edit-data-and-skills">Edit</a>
                                </div>
                              </div> --}}
                            </div>
                          </div>
                        </div>
                          <div class="row gutters-sm">
                            <div class="col-sm-12 mb-3">
                              <div class="card h-100">
                                <div class="card-body">
                                  <ul class="nav nav-fill nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                      <a class="nav-link active" id="fill-tab-0" data-bs-toggle="tab" href="#fill-tabpanel-0" role="tab" aria-controls="fill-tabpanel-0" aria-selected="true"> Data Pokok </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                      <a class="nav-link" id="fill-tab-1" data-bs-toggle="tab" href="#fill-tabpanel-1" role="tab" aria-controls="fill-tabpanel-1" aria-selected="false"> Alamat Lengkap </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                      <a class="nav-link" id="fill-tab-2" data-bs-toggle="tab" href="#fill-tabpanel-2" role="tab" aria-controls="fill-tabpanel-2" aria-selected="false"> Data Orangtua/Wali</a>
                                    </li>
                                  </ul>
                                  <div class="tab-content pt-5" id="tab-content">
                                    <div class="tab-pane active" id="fill-tabpanel-0" role="tabpanel" aria-labelledby="fill-tab-0">Tab 1 selected</div>
                                    <div class="tab-pane" id="fill-tabpanel-1" role="tabpanel" aria-labelledby="fill-tab-1">Tab Tab 2 selected</div>
                                    <div class="tab-pane" id="fill-tabpanel-2" role="tabpanel" aria-labelledby="fill-tab-2">Tab Tab 3 selected</div>
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
    
</div>
@endsection
