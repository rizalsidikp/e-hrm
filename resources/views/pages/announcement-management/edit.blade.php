@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Informasi Pengumuman') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form id="announcement-create" action="/announcement-management/{{ $announcement->id }}" method="POST"
                        role="form text-left">
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
                                    <label for="announcement.judul"
                                        class="form-control-label">{{ __('Judul Pengumuman') }}</label>
                                    <input class="form-control" type="text" placeholder="Judul Pengumuman"
                                        id="announcement.judul" name="judul"
                                        value="{{ old('judul', $announcement->judul) }}" required>
                                    @error('judul')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="announcement.banner"
                                        class="form-control-label">{{ __('Banner') }}</label>
                                    <div action="/" class="form-control border dropzone" id="dropzone">
                                        <div class="fallback">
                                        </div>
                                    </div>
                                    <input id="announcement.banner" name="banner" type="hidden" value="{{$announcement->banner}}" /><br/>
                                    @if(!!$announcement->banner)
                                    Banner saat ini : <img src="{{ asset($announcement->banner) }}" alt="banner" style="max-width: 300px" />
                                    @endif
                                    @error('banner')
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
                                    <input type="hidden" id="deskripsi" name="deskripsi">
                                    <div id="deskripsi_konten" style="height: 400px" name="deskripsi">
                                        <p>{!! old('deskripsi', $announcement->deskripsi) !!}</p>
                                    </div>
                                    @error('deskripsi')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="announcement.link"
                                        class="form-control-label">{{ __('Link Google Drive') }}</label>
                                    <input class="form-control" type="text" placeholder="https://drive.google.com/drive"
                                        id="announcement.link" name="link"
                                        value="{{ old('link', $announcement->link) }}">
                                    @error('link')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="announcement.active"
                                        class="form-control-label">{{ __('Status Aktif Pengumuman') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="active" id="announcement.active"
                                            {{ old('active', $announcement->active ? 'on' : null) === 'on' ? 'checked' : '' }}>
                                    </div>
                                    @error('active')
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
        var quill = new Quill('#deskripsi_konten', {
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'link'],
                    [{ 'align': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'indent': '-1'}, { 'indent': '+1' }],
                    ['image']
                ]
            },
            theme: 'snow'  // or 'bubble'
        });
        @if (old('deskripsi', $announcement->deskripsi))
            var editorContent = @json(old('deskripsi', $announcement->deskripsi));
            quill.setContents(JSON.parse(editorContent));
        @endif

        var form = document.getElementById('announcement-create');
        form.onsubmit = function() {
            var delta = quill.getContents();
            var htmlContent = JSON.stringify(delta);
            document.getElementById('deskripsi').value = htmlContent;
        };
    </script>
    <script type="text/javascript">
        const defaultBanner = "{{ $announcement->banner }}"
        Dropzone.autoDiscover = false;
        var drop = document.getElementById('dropzone')
        var myDropzone = new Dropzone(drop, {
            url: "{{ route('announcement-management.banner') }}",
            addRemoveLinks: true,
            paramName: 'banner',
            acceptedFiles: 'image/jpeg,image/png,image/jpg',
            dictDefaultMessage: 'Seret berkas atau klik di sini untuk mengunggah <br/> .png | .jpg | .jpeg',
            dictRemoveFile: 'Hapus berkas',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Menambahkan CSRF token ke dalam header
            },
            maxFiles: 1,
            init: function() {
                var fileInput = document.getElementById('announcement.banner');
                this.on("complete", function(file) {
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                        if (file.xhr && file.xhr.response) {
                            var response = JSON.parse(file.xhr.response);
                            if (response.banner) {
                                fileInput.value = response.banner;
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
                    fileInput.value = defaultBanner
                });
                this.on("error", function(file, errorMessage) {
                    var errorPreview = document.createElement('div');
                    errorPreview.classList.add('dz-error-message');
                    errorPreview.textContent = errorMessage;
                    file.previewElement.appendChild(errorPreview);
                    fileInput.value = null
                });
            }
        });
    </script>
@endsection
