@extends('layouts.user_type.auth')
@php
    $roles = ["superadmin", "admin", "manajer", "pengawas", "user"]
@endphp
@section('content')
    <div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Informasi Pegawai') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.nama" class="form-control-label">{{ __('Nama Lengkap') }}</label>
                                <input class="form-control custom-disabled" type="text" placeholder="John Doe" id="user.nama"
                                    name="nama" value="{{ old('nama', $user->nama) }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.email" class="form-control-label">{{ __('Email') }}</label>
                                <input class="form-control custom-disabled" type="email" placeholder="@example.com" id="user.email"
                                    name="email" value="{{ old('email', $user->email) }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.username" class="form-control-label">{{ __('Username') }}</label>
                                <input class="form-control custom-disabled" type="text" placeholder="username" id="user.username"
                                    name="username" value="{{ old('username', $user->username) }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.role"
                                    class="form-control-label">{{ __('Role') }}</label>
                                <select class="form-control custom-disabled" id="user.role" name="role" disabled>
                                    @foreach ($roles as $role)
                                        <option value="{{$role}}"
                                            {{ old('role', $user->role) === $role ? 'selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.jabatan" class="form-control-label">{{ __('Jabatan') }}</label>
                                <input class="form-control custom-disabled" type="text" placeholder="Manager" id="user.jabatan"
                                    name="jabatan" value="{{ old('jabatan', $user->jabatan) }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.jenis_kelamin"
                                    class="form-control-label">{{ __('Jenis Kelamin') }}</label>
                                <select class="form-control custom-disabled" id="user.jenis_kelamin" name="jenis_kelamin" disabled>
                                    <option value="l"
                                        {{ old('jenis_kelamin', $user->jenis_kelamin) === 'l' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="p"
                                        {{ old('jenis_kelamin', $user->jenis_kelamin) === 'p' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.tempat_lahir"
                                    class="form-control-label">{{ __('Tempat Lahir') }}</label>
                                <input class="form-control custom-disabled" type="text" placeholder="Jakarta" id="user.tempat_lahir"
                                    name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.tanggal_lahir"
                                    class="form-control-label">{{ __('Tanggal Lahir') }}</label>
                                <input class="form-control datepicker" type="date" id="user.tanggal_lahir" name="tanggal_lahir"
                                    placeholder="" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="user.alamat">{{ 'Alamat' }}</label>
                            <textarea disabled class="form-control custom-disabled" style="resize:none" id="user.alamat" rows="3" placeholder="Jl..."
                                name="alamat">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.mulai_bekerja"
                                    class="form-control-label">{{ __('Mulai Bekerja') }}</label>
                                <input class="form-control datepicker" type="date" id="user.mulai_bekerja"
                                    name="mulai_bekerja" placeholder=""
                                    value="{{ old('mulai_bekerja', $user->mulai_bekerja) }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.status"
                                    class="form-control-label">{{ __('Status Pekerjaan') }}</label>
                                <select class="form-control custom-disabled" id="user.status" name="status" disabled>
                                    <option value="Kontrak"
                                        {{ old('status', $user->status) === 'Kontrak' ? 'selected' : '' }}>
                                        Kontrak</option>
                                    <option value="On Job Training"
                                        {{ old('status', $user->status) === 'On Job Training' ? 'selected' : '' }}>On
                                        Job Training
                                    </option>
                                    <option value="Permanen"
                                        {{ old('status', $user->status) === 'Permanen' ? 'selected' : '' }}>
                                        Permanen</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.no_hp" class="form-control-label">{{ __('No HP') }}</label>
                                <input class="form-control custom-disabled" type="text" placeholder="085273674273"
                                    id="user.no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.gaji" class="form-control-label">{{ __('Gaji') }}</label>
                                <input class="form-control custom-disabled" type="number" id="user.gaji" name="gaji"
                                    placeholder="4500000" value="{{ old('gaji', $user->gaji) }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" id="backButton"
                        class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Kembali' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-content')
    <script>
        if (document.querySelector('.datepicker')) {
            flatpickr('.datepicker', {

            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#backButton').click(function() {
                window.history.back();
            });
        });
    </script>
@endsection

