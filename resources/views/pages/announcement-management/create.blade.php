@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Informasi Pengumuman') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="/user-management" method="POST" role="form text-left">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="announcement.judul"
                                        class="form-control-label">{{ __('Judul Pengumuman') }}</label>
                                    <input class="form-control" type="text" placeholder="Judul Pengumuman"
                                        id="announcement.judul" name="judul" value="{{ old('judul') }}" required>
                                    @error('judul')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="announcement.deskripsi"
                                        class="form-control-label">{{ __('Detail Pengumuman') }}</label>
                                    <div id="deskripsi">

                                    </div>
                                    @error('deskripsi')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="announcement.link"
                                        class="form-control-label">{{ __('Link Google Drive') }}</label>
                                    <input class="form-control" type="text" placeholder="https://drive.google.com/drive"
                                        id="announcement.link" name="link" value="{{ old('link') }}" required>
                                    @error('link')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
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
        var quill = new Quill('#deskripsi', {
            theme: 'snow' // Specify theme in configuration
        });
    </script>
@endsection
