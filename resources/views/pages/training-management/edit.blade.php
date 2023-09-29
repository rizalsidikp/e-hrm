@extends('layouts.user_type.auth')
@section('content')
    <div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Informasi Pelatihan') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form id="training-create" action="/training-management/{{ $training->id }}" method="POST" role="form text-left" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                    <label for="training.tipe_pelatihan"
                                        class="form-control-label">{{ __('Tipe Pelatihan') }}</label>
                                    <select disabled class="form-control cursor-pointer" id="training.tipe_pelatihan" name="tipe_pelatihan">
                                        <option value="pegawai" {{ old('tipe_pelatihan', $training->tipe_pelatihan) === 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                                        <option value="perusahaan" {{ old('tipe_pelatihan', $training->tipe_pelatihan) === 'perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                                    </select>
                                    @error('tipe_pelatihan')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row" id="input-pegawai">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="training.user_id"
                                        class="form-control-label">{{ __('Nama Pegawai') }}</label>
                                    <select class="form-control cursor-pointer" id="training.user_id" name="user_id" required>
                                        @foreach ($users as $key => $user)
                                            <option value="{{ $user->id }}"
                                                {{ (int) old('user_id', !!$training->user ? $training->user->id : null) === $user->id ? 'selected' : '' }}>
                                                {{ $user->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="training.nama" class="form-control-label">{{ __('Nama Pelatihan') }}</label>
                                    <input class="form-control" type="text" placeholder="Nama Pelatihan" id="training.nama"
                                        name="nama" value="{{ old('nama', $training->nama) }}" required>
                                    @error('nama')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="training.deskripsi">{{ 'Deskripsi' }}</label>
                                    <textarea class="form-control" style="resize:none" id="training.deskripsi" rows="3" placeholder="Deskripsi Pelatihan"
                                        name="deskripsi">{{ old('deskripsi', $training->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="training.file"
                                        class="form-control-label">{{ __('File Sertifikat') }}</label>
                                    <div action="/" class="form-control border dropzone" id="dropzone">
                                        <div class="fallback">
                                        </div>
                                    </div>
                                    <input id="training.file" name="file" type="hidden" value="{{$training->file}}" /><br/>
                                    File sertifikat saat ini : <a href="{{ asset($training->file) }}" download>Download Sertifikat</a>
                                    @error('file')
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
<script type="text/javascript">
    const defaultFile = "{{ $training->file }}"
    Dropzone.autoDiscover = false;
    var drop = document.getElementById('dropzone')
    var myDropzone = new Dropzone(drop, {
        url: "{{ route('training-management.file') }}",
        addRemoveLinks: true,
        paramName: 'file',
        dictDefaultMessage: 'Seret berkas atau klik di sini untuk mengunggah',
        dictRemoveFile: 'Hapus berkas',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Menambahkan CSRF token ke dalam header
        },
        maxFiles: 1,
        init: function() {
            var fileInput = document.getElementById('training.file');
            this.on("complete", function(file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    if (file.xhr && file.xhr.response) {
                        var response = JSON.parse(file.xhr.response);
                        if (response.file) {
                            fileInput.value = response.file;
                        }
                    }
                }
            });
            this.on("addedfile", function(file) {
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]); // Menghapus berkas pertama
                }
            });
            this.on("removedfile", function(file){
                fileInput.value = defaultFile
            });
            this.on("error", function(file, errorMessage) {
                var errorPreview = document.createElement('div');
                errorPreview.classList.add('dz-error-message');
                errorPreview.textContent = errorMessage;
                file.previewElement.appendChild(errorPreview);
                buktiInput.value = null
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tipe = document.getElementById('training.tipe_pelatihan').value;
        handleTipeChange(tipe);
    });

    document.getElementById('training.tipe_pelatihan').addEventListener('change', function() {
        var tipe = this.value;
        handleTipeChange(tipe);
    });

    function handleTipeChange(tipe) {
        if (tipe === 'pegawai') {
            document.getElementById('input-pegawai').style.display = 'flex';
        } else {
            document.getElementById('input-pegawai').style.display = 'none';
        }
    }
</script>
@endsection
