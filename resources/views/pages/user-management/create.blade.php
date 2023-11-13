@extends('layouts.user_type.auth')
@php
    $roles = ["admin", "manajer", "pengawas", "user"]
@endphp
@section('content')
    <div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Informasi Pegawai') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="/user-management" method="POST" role="form text-left" enctype="multipart/form-data">
                        @csrf
                        @if ($errors->any())
                            <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                                <span class="alert-text text-white">
                                    {{ $errors->first() }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success"
                                role="alert">
                                <span class="alert-text text-white">
                                    {{ session('success') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div>
                                    <label for="user.photo" class="form-control-label">{{ __('Photo Pegawai') }}</label>
                                </div>
                                <div class="avatar avatar-xl position-relative">
                                    <img src="{{ asset('assets/img/default-user-image.png') }}" alt="..." class="w-100 border-radius-lg shadow-sm" id="avatar-preview" style="height: 100%;object-fit: cover;">
                                    <a id="edit-avatar" href="javascript:;" class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                        <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Photo" style="font-size: 10px"></i>
                                    </a>
                                    <input type="file" name="photo" id="avatar-input" style="display: none" accept="image/*" value="{{ old('photo') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user.nama" class="form-control-label">{{ __('Nama Lengkap') }}</label>
                                    <input class="form-control" type="text" placeholder="John Doe" id="user.nama"
                                        name="nama" value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user.email" class="form-control-label">{{ __('Email') }}</label>
                                    <input class="form-control" type="email" placeholder="@example.com" id="user.email"
                                        name="email" value="{{ old('email') }}" required>
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
                                        name="username" value="{{ old('username') }}" required>
                                    @error('username')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user.role"
                                        class="form-control-label">{{ __('Role') }}</label>
                                    <select class="form-control" id="user.role" name="role" required>
                                        @foreach ($roles as $role)
                                            <option value="{{$role}}"
                                                {{ old('role', 'user') === $role ? 'selected' : '' }}>{{ $role }}</option>
                                        @endforeach
                                    </select>
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
                                        name="jabatan" value="{{ old('jabatan') }}" required>
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
                                        <option value="l" {{ old('jenis_kelamin') === 'l' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="p" {{ old('jenis_kelamin') === 'p' ? 'selected' : '' }}>
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
                                        name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                                    @error('tempat_lahir')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user.tanggal_lahir"
                                        class="form-control-label">{{ __('Tanggal Lahir') }}</label>
                                    <input class="form-control datepicker" type="date" id="user.tanggal_lahir"
                                        name="tanggal_lahir" placeholder="" value="{{ old('tanggal_lahir') }}" required>
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
                                    name="alamat">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user.mulai_bekerja"
                                        class="form-control-label">{{ __('Mulai Bekerja') }}</label>
                                    <input class="form-control datepicker" type="date" id="user.mulai_bekerja"
                                        name="mulai_bekerja" placeholder="" value="{{ old('mulai_bekerja') }}" required>
                                    @error('mulai_bekerja')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user.status"
                                        class="form-control-label">{{ __('Status Pekerjaan') }}</label>
                                    <select class="form-control" id="user.status" name="status">
                                        <option value="Kontrak" {{ old('status') === 'Kontrak' ? 'selected' : '' }}>
                                            Kontrak</option>
                                        <option value="On Job Training"
                                            {{ old('status') === 'On Job Training' ? 'selected' : '' }}>On Job Training
                                        </option>
                                        <option value="Permanen" {{ old('status') === 'Permanen' ? 'selected' : '' }}>
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
                                    <input class="form-control" type="text" placeholder="085273674273"
                                        id="user.no_hp" name="no_hp" value="{{ old('no_hp') }}">
                                    @error('no_hp')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user.gaji" class="form-control-label">{{ __('Gaji') }}</label>
                                    <input class="form-control" type="number" id="user.gaji" name="gaji"
                                        placeholder="4500000" value="{{ old('gaji') }}" required>
                                    @error('gaji')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <h6 class="py-4">{{ __('Login Pegawai') }}</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user.password" class="form-control-label">{{ __('Password') }}</label>
                                    <input class="form-control" type="password" id="user.password" name="password"
                                        placeholder="" required>
                                    @error('password')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
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
                            <button type="submit" id="backButton"
                                  class="btn bg-gradient-secondary btn-md mt-4 mb-4 mx-4">{{ 'Kembali' }}</button>
                            <button type="submit"
                                class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Simpan' }}</button>
                        </div>
                    </form>
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
           // Memeriksa apakah ada gambar yang dipilih saat halaman dimuat
            const initialAvatar = $('#avatar-input').prop('files')[0];
            if (initialAvatar) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Mengganti src gambar dengan data URL dari gambar yang sudah dipilih sebelumnya
                    $('#avatar-preview').attr('src', e.target.result);
                };

                reader.readAsDataURL(initialAvatar);
            }
       });
   </script>
   <script>
    $(document).ready(function() {
        $('#backButton').click(function() {
            window.history.back();
        });
    });
</script>
@endsection
