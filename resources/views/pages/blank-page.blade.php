@extends('layouts.app')

@section('title', 'New User')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Formulir Registrasi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Users</a></div>
                    <div class="breadcrumb-item">New User</div>
                </div>
            </div>

            <div class="section-body">

                <div class="card">
                    <form action="{{ route('registrasi.store') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <h4>Register</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input type="text" class="form-control @error('handphone') is-invalid @enderror" name="handphone">
                                @error('handphone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">{{ __('Tanggal Lahir') }}</label>
                                <input id="tanggal_lahir" type="date" class="form-control" name="tanggal_lahir" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="jenis_kelamin" value="Laki-laki" class="selectgroup-input" checked>
                                        <span class="selectgroup-button">Laki-laki</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="jenis_kelamin" value="Perempuan" class="selectgroup-input">
                                        <span class="selectgroup-button">Perempuan</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="agama">{{ __('Agama') }}</label>
                                <select id="agama" class="form-control" name="agama" required>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Khonghucu">Lainnya</option>
                                </select>
                            </div>
                            <div class="form-group mb-0">
                                <label>Biografi</label>
                                <textarea class="form-control" data-height="150" name="biografi"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="foto_ktp">{{ __('Foto KTP') }}</label>
                                <input id="foto_ktp" type="file" class="form-control-file" name="foto_ktp" accept="image/*" required>
                            </div>
                            <div class="form-group form-check">
                                <input id="pemberitahuan_via_email" type="checkbox" class="form-check-input" name="pemberitahuan_via_email" value="1">
                                <label for="pemberitahuan_via_email" class="form-check-label">{{ __('Saya ingin pemberitahuan via email') }}</label>
                            </div>
                            
                            <div class="form-group form-check">
                                <input id="pemberitahuan_via_nomor_telepon" type="checkbox" class="form-check-input" name="pemberitahuan_via_nomor_telepon" value="1">
                                <label for="pemberitahuan_via_nomor_telepon" class="form-check-label">{{ __('Saya ingin pemberitahuan via nomor telepon') }}</label>
                            </div>
                                                  
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->

    <!-- Page Specific JS File -->
@endpush
