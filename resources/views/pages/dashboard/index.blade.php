@extends('layouts.user_type.auth')

@section('content')
    <form action="/dashboard/{{ $user->id }}" method="POST" role="form text-left" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if ($errors->any() || session('error'))
            <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                <span class="alert-text text-white">
                    {{ $errors->any() ? $errors->first() : session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
        @endif
        @if (session('success'))
            <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                <span class="alert-text text-white">
                    {{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
        @endif
        <div class="container-fluid">
            <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div>
            <div class="card card-body blur shadow-blur mx-4 mt-n6">
                <div class="row gx-4">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="@if($user->photo) {{ asset($user->photo) }} @else {{ asset('assets/img/default-user-image.png') }} @endif" alt="..." class="w-100 border-radius-lg shadow-sm" id="avatar-preview" style="height: 100%;object-fit: cover;">
                            <a id="edit-avatar" href="javascript:;" class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Photo" style="font-size: 10px"></i>
                            </a>
                            <input type="file" name="photo" id="avatar-input" style="display: none" accept="image/*">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ __($user->nama) }}
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm">
                                {{ __($user->jabatan) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Informasi Data Diri') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.nama" class="form-control-label">{{ __('Nama Lengkap') }}</label>
                                <input class="form-control" type="text" placeholder="John Doe" id="user.nama"
                                    name="nama" value="{{ old('nama', $user->nama) }}" required>
                                @error('nama')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.email" class="form-control-label">{{ __('Email') }}</label>
                                <input class="form-control" type="email" placeholder="@example.com" id="user.email"
                                    name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.username" class="form-control-label">{{ __('Username') }}</label>
                                <input class="form-control" type="text" placeholder="username" id="user.username"
                                    name="username" value="{{ old('username', $user->username) }}" required>
                                @error('username')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.role" class="form-control-label">{{ __('Role') }}</label>
                                <input class="form-control" type="text" placeholder="role" id="user.role"
                                    name="role" value="{{ old('role', $user->role) }}" disabled>
                                @error('role')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.jabatan" class="form-control-label">{{ __('Jabatan') }}</label>
                                <input class="form-control" type="text" placeholder="Manager" id="user.jabatan"
                                    name="jabatan" value="{{ old('jabatan', $user->jabatan) }}" required disabled>
                                @error('jabatan')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.jenis_kelamin"
                                    class="form-control-label">{{ __('Jenis Kelamin') }}</label>
                                <select class="form-control" id="user.jenis_kelamin" name="jenis_kelamin">
                                    <option value="l"
                                        {{ old('jenis_kelamin', $user->jenis_kelamin) === 'l' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="p"
                                        {{ old('jenis_kelamin', $user->jenis_kelamin) === 'p' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.tempat_lahir"
                                    class="form-control-label">{{ __('Tempat Lahir') }}</label>
                                <input class="form-control" type="text" placeholder="Jakarta" id="user.tempat_lahir"
                                    name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" required>
                                @error('tempat_lahir')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.tanggal_lahir"
                                    class="form-control-label">{{ __('Tanggal Lahir') }}</label>
                                <input class="form-control" type="date" id="user.tanggal_lahir" name="tanggal_lahir"
                                    placeholder="" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" required>
                                @error('tanggal_lahir')
                                    <p class="text-danger
                                        text-xs mt-2">
                                        {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="user.alamat">{{ 'Alamat' }}</label>
                            <textarea class="form-control" style="resize:none" id="user.alamat" rows="3" placeholder="Jl..."
                                name="alamat">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.mulai_bekerja"
                                    class="form-control-label">{{ __('Mulai Bekerja') }}</label>
                                <input class="form-control" type="date" id="user.mulai_bekerja" name="mulai_bekerja"
                                    placeholder="" value="{{ old('mulai_bekerja', $user->mulai_bekerja) }}" required
                                    disabled>
                                @error('mulai_bekerja')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.status" class="form-control-label">{{ __('Status Pekerjaan') }}</label>
                                <select class="form-control" id="user.status" name="status" disabled>
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
                                @error('status')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.no_hp" class="form-control-label">{{ __('No HP') }}</label>
                                <input class="form-control" type="text" placeholder="085273674273" id="user.no_hp"
                                    name="no_hp" value="{{ old('no_hp', $user->no_hp) }}">
                                @error('no_hp')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.gaji" class="form-control-label">{{ __('Gaji') }}</label>
                                <input class="form-control" type="number" id="user.gaji" name="gaji"
                                    placeholder="4500000" value="{{ old('gaji', $user->gaji) }}" required disabled>
                                @error('gaji')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <h6 class="py-4">{{ __('Ganti Password') }}</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user.current_password"
                                    class="form-control-label">{{ __('Password Saat Ini') }}</label>
                                <input class="form-control" type="password" id="user.current_password"
                                    name="current_password">
                                @error('current_password')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user.password" class="form-control-label">{{ __('Password') }}</label>
                                <input class="form-control" type="password" id="user.password" name="password"
                                    placeholder="">
                                @error('password')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user.password_confirmation"
                                    class="form-control-label">{{ __('Konfirmasi Password') }}</label>
                                <input class="form-control" type="password" id="user.password_confirmation"
                                    name="password_confirmation" placeholder="">
                                @error('password_confirmation')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Simpan' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @php
        $active = false;
        $data = [
            'user_id' => Auth::user()->id,
            'label' => 'Dashboard',
            'icon' => 'fa-home',
            'url' => 'dashboard',
        ];
        if(in_array($data, $favorites)){
            $active = true;
        }
    @endphp
    @include('components.fixed-plugin', [
        'active' => $active,
        ...$data
    ])
@endsection
@section('page-content')
<script>
     $(document).ready(function() {
        $('#edit-avatar').click(function() {
            $('#avatar-input').click();
        });
        $('#avatar-input').change(function() {
            const input = this;

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Mengganti src gambar dengan data URL dari gambar yang dipilih
                    $('#avatar-preview').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>
@endsection
