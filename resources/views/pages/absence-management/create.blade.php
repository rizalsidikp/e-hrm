 @extends('layouts.user_type.auth')

 @section('content')
     <div>
         <div class="container-fluid py-4">
             <div class="card">
                 <div class="card-header pb-0 px-3">
                     <h6 class="mb-0">{{ __('Informasi Pengajuan') }}</h6>
                 </div>
                 <div class="card-body pt-4 p-3">
                     <form action="/{{ $menuUrl }}" method="POST" role="form text-left" enctype="multipart/form-data">
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
                         @if ($menuUrl === 'absence-management')
                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="form-group">
                                         <label for="absence.user_id"
                                             class="form-control-label">{{ __('Nama Pegawai') }}</label>
                                         <select class="form-control" id="absence.user_id" name="user_id">
                                             @foreach ($users as $key => $user)
                                                 <option value="{{ $user->id }}"
                                                     {{ (int) old('user_id') === $user->id ? 'selected' : '' }}>
                                                     {{ $user->nama }}</option>
                                             @endforeach
                                         </select>
                                         @error('nama')
                                             <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                         @enderror
                                     </div>
                                 </div>
                             </div>
                         @endif
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="absence.status"
                                         class="form-control-label">{{ __('Jenis Pengajuan') }}</label>
                                     <select class="form-control" id="absence.status" name="status">
                                         <option value="izin" {{ old('status') === 'izin' ? 'selected' : '' }}>
                                             Izin</option>
                                         <option value="sakit" {{ old('status') === 'sakit' ? 'selected' : '' }}>
                                             Sakit</option>
                                     </select>
                                     @error('status')
                                         <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                     @enderror
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="absence.tipe"
                                         class="form-control-label">{{ __('Tipe Pengajuan') }}</label>
                                     <select class="form-control" id="absence.tipe" name="tipe">
                                         <option value="hari" {{ old('tipe') === 'hari' ? 'selected' : '' }}>
                                             Hari</option>
                                         <option value="jam" {{ old('tipe') === 'jam' ? 'selected' : '' }}>
                                             Jam</option>
                                     </select>
                                     @error('tipe')
                                         <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                     @enderror
                                 </div>
                             </div>
                         </div>
                         <div class="row" id="form-tanggal">
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="absence.tanggal_mulai"
                                         class="form-control-label">{{ __('Tanggal Mulai') }}</label>
                                     <input id="absence.tanggal_mulai" name="tanggal_mulai" class="form-control datepicker"
                                         placeholder="Please select date" type="text" value="{{ old('tanggal_mulai') }}"
                                         onfocus="focused(this)" onfocusout="defocused(this)" required>
                                     @error('tanggal_mulai')
                                         <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                     @enderror
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="absence.tanggal_selesai"
                                         class="form-control-label">{{ __('Tanggal Selesai') }}</label>
                                     <input id="absence.tanggal_selesai" name="tanggal_selesai"
                                         class="form-control datepicker" placeholder="Please select date" type="text"
                                         value="{{ old('tanggal_selesai') }}" onfocus="focused(this)"
                                         onfocusout="defocused(this)" required>
                                     @error('tanggal_selesai')
                                         <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                     @enderror
                                 </div>
                             </div>
                         </div>
                         <div class="row" id="form-tanggal-jam">
                             <div class="col-md-12">
                                 <div class="form-group">
                                     <label for="absence.tanggal" class="form-control-label">{{ __('Tanggal') }}</label>
                                     <input id="absence.tanggal" name="tanggal" class="form-control datepicker"
                                         placeholder="Please select date" type="text" value="{{ old('tanggal') }}"
                                         onfocus="focused(this)" onfocusout="defocused(this)" required>
                                     @error('tanggal')
                                         <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                     @enderror
                                 </div>
                             </div>
                         </div>
                         <div class="row" id="form-jam" style="display: none">
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="absence.jam_mulai"
                                         class="form-control-label">{{ __('Jam Mulai') }}</label>
                                     <input id="absence.jam_mulai" name="jam_mulai" class="form-control timepicker"
                                         placeholder="Please select date" type="text" value="{{ old('jam_mulai') }}"
                                         onfocus="focused(this)" onfocusout="defocused(this)" required>
                                     @error('jam_mulai')
                                         <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                     @enderror
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="absence.jam_selesai"
                                         class="form-control-label">{{ __('Jam Selesai') }}</label>
                                     <input id="absence.jam_selesai" name="jam_selesai" class="form-control timepicker"
                                         placeholder="Please select date" type="text"
                                         value="{{ old('jam_selesai') }}" onfocus="focused(this)"
                                         onfocusout="defocused(this)" required>
                                     @error('jam_selesai')
                                         <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                     @enderror
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="form-group">
                                 <label for="absence.alasan">{{ 'alasan' }}</label>
                                 <textarea class="form-control" style="resize:none" id="absence.alasan" rows="3"
                                     placeholder="Alasan Izin / Sakit" name="alasan">{{ old('alasan') }}</textarea>
                                 @error('alasan')
                                     <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                 @enderror
                             </div>
                         </div>
                         <div class="row">
                             @if ($menuUrl === 'absence-management')
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="absence.pemotongan"
                                             class="form-control-label">{{ __('Pemotongan Gaji') }}</label>
                                         <div class="form-check form-switch">
                                             <input class="form-check-input" type="checkbox" name="pemotongan"
                                                 id="absence.pemotongan" {{ old('pemotongan') ? 'checked' : '' }}>
                                         </div>
                                         @error('pemotongan')
                                             <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                         @enderror
                                     </div>
                                 </div>
                             @endif
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <label for="absence.bukti"
                                         class="form-control-label">{{ __('Bukti Izin / Sakit') }}</label>
                                     <div action="/" class="form-control border dropzone" id="dropzone">
                                         <div class="fallback">
                                         </div>
                                     </div>
                                     <input id="absence.bukti" name="bukti" type="hidden" />
                                     @error('bukti')
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
     @php
        $active = false;
        $data = [
            'user_id' => Auth::user()->id,
            'label' => $menuUrl === 'absence' ? 'Pengajuan Absensi' : 'Absensi Pegawai Baru',
            'icon' => $menuUrl === 'absence' ? 'fa-calendar-minus' : 'fa-calendar-check',
            'url' => $menuUrl.'/create',
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
     <script type="text/javascript">
         if (document.getElementById('absence.user_id')) {
             var element = document.getElementById('absence.user_id');
             const example = new Choices(element, {});
         }
     </script>
     <script>
         if (document.querySelector('.datepicker')) {
             flatpickr('.datepicker', {

             });
         }
     </script>
     <script>
         if (document.querySelector('.timepicker')) {
             let fp = flatpickr('.timepicker', {
                 enableTime: true,
                 noCalendar: true,
                 dateFormat: "H:i",
                 time_24hr: true,
                 defaultMinute: 0,
                 minuteIncrement: 0
             });
         }
     </script>
     <script type="text/javascript">
         Dropzone.autoDiscover = false;
         var drop = document.getElementById('dropzone')
         var myDropzone = new Dropzone(drop, {
             url: "{{ route('absence-management.bukti') }}",
             addRemoveLinks: true,
             paramName: 'bukti',
             acceptedFiles: 'image/jpeg,image/png,image/jpg',
             dictDefaultMessage: 'Seret berkas atau klik di sini untuk mengunggah <br/> .png | .jpg | .jpeg',
             dictRemoveFile: 'Hapus berkas',
             headers: {
                 'X-CSRF-TOKEN': '{{ csrf_token() }}' // Menambahkan CSRF token ke dalam header
             },
             maxFiles: 1,
             init: function() {
                 var buktiInput = document.getElementById('absence.bukti');
                 this.on("complete", function(file) {
                     if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                         if (file.xhr && file.xhr.response) {
                             var response = JSON.parse(file.xhr.response);
                             if (response.bukti) {
                                 buktiInput.value = response.bukti;
                             }
                         }
                     }
                 });
                 this.on("addedfile", function(file) {
                     if (this.files.length > 1) {
                         this.removeFile(this.files[0]); // Menghapus berkas pertama
                     }
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
             var tipe = document.getElementById('absence.tipe').value;
             var status = document.getElementById('absence.status').value;
             handleTipeChange(tipe);
         });

         document.getElementById('absence.tipe').addEventListener('change', function() {
             var tipe = this.value;
             handleTipeChange(tipe);
         });
         this.on("removedfile", function(file){
            fileInput.value = null
         });
         function handleTipeChange(tipe) {
             if (tipe === 'hari') {
                 document.getElementById('form-tanggal').style.display = 'flex';
                 document.getElementById('form-jam').style.display = 'none';
                 document.getElementById('form-tanggal-jam').style.display = 'none';
             } else if (tipe === 'jam') {
                 document.getElementById('form-tanggal').style.display = 'none';
                 document.getElementById('form-jam').style.display = 'flex';
                 document.getElementById('form-tanggal-jam').style.display = 'flex';
             }
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
