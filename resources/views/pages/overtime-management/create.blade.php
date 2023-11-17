@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Informasi Pengajuan') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="/overtime-management" method="POST" role="form text-left" enctype="multipart/form-data">
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
                                    <label for="overtime.user_id"
                                        class="form-control-label">{{ __('Nama Pegawai') }}</label>
                                    <select class="form-control" id="overtime.user_id" name="user_id" required>
                                        @foreach ($users as $key => $user)
                                            <option value="{{ $user->id }}"
                                                {{ (int) old('user_id') === $user->id ? 'selected' : '' }}>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="overtime.tanggal" class="form-control-label">{{ __('Tanggal') }}</label>
                                    <input id="overtime.tanggal" name="tanggal" class="form-control datepicker"
                                        placeholder="Please select date" type="text" value="{{ old('tanggal') }}"
                                        onfocus="focused(this)" onfocusout="defocused(this)" required>
                                    @error('tanggal')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="overtime.shift" class="form-control-label">{{ __('Shift') }}</label>
                                    <select class="form-control" id="overtime.shift" name="shift" required>
                                        <option value="pagi" {{ old('shift') === 'pagi' ? 'selected' : '' }}>
                                            Pagi</option>
                                        <option value="siang" {{ old('shift') === 'siang' ? 'selected' : '' }}>
                                            Siang</option>
                                    </select>
                                    @error('shift')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="overtime.jam_mulai"
                                        class="form-control-label">{{ __('Jam Mulai') }}</label>
                                    <input id="overtime.jam_mulai" name="jam_mulai" class="form-control timepicker"
                                        placeholder="Please select date" type="text" value="{{ old('jam_mulai') }}"
                                        onfocus="focused(this)" onfocusout="defocused(this)" required>
                                    @error('jam_mulai')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="overtime.jam_selesai"
                                        class="form-control-label">{{ __('Jam Selesai') }}</label>
                                    <input id="overtime.jam_selesai" name="jam_selesai" class="form-control timepicker"
                                        placeholder="Please select date" type="text" value="{{ old('jam_selesai') }}"
                                        onfocus="focused(this)" onfocusout="defocused(this)" required>
                                    @error('jam_selesai')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="overtime.pengawas_id"
                                        class="form-control-label">{{ __('Nama Pengawas') }}</label>
                                    @if (auth()->user()->role === 'pengawas')
                                        <select class="form-control custom-disabled" id="overtime.pengawas_id"
                                            name="pengawas_id" disabled>
                                            @foreach ($users as $key => $user)
                                                @if($user->role === 'pengawas')
                                                <option value="{{ $user->id }}"
                                                    {{ auth()->user()->id === $user->id ? 'selected' : '' }}>
                                                    {{ $user->nama }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-control" id="overtime.pengawas_id" name="pengawas_id" required>
                                            @foreach ($users as $key => $user)
                                                @if($user->role === 'pengawas')
                                                <option value="{{ $user->id }}"
                                                    {{ (int) old('pengawas_id') === $user->id ? 'selected' : '' }}>
                                                    {{ $user->nama }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('pengawas_id')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="overtime.manajer_id"
                                        class="form-control-label">{{ __('Nama Manajer') }}</label>
                                    <select class="form-control" id="overtime.manajer_id" name="manajer_id" required>
                                        @foreach ($users as $key => $user)
                                            @if($user->role === 'manajer')
                                            <option value="{{ $user->id }}"
                                                {{ (int) old('manajer_id') === $user->id ? 'selected' : '' }}>
                                                {{ $user->nama }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('manajer_id')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="overtime.jumlah_operator"
                                        class="form-control-label">{{ __('Jumlah Operator') }}</label>
                                    <input class="form-control" type="text" placeholder="Jumlah Operator"
                                        id="overtime.jumlah_operator" name="jumlah_operator"
                                        value="{{ old('jumlah_operator') }}" required>
                                    @error('jumlah_operator')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="overtime.alasan"
                                        class="form-control-label">{{ __('Alasan Memberi Perintah OT') }}</label>
                                    <input class="form-control" type="text" placeholder="Alasan Memberi Perintah OT"
                                        id="overtime.alasan" name="alasan" value="{{ old('alasan') }}" required>
                                    @error('alasan')
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
            'label' => 'Lembur Pegawai Baru',
            'icon' => 'fa-business-time',
            'url' => 'overtime-management/create',
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
        if (document.getElementById('overtime.user_id')) {
            var element = document.getElementById('overtime.user_id');
            const example = new Choices(element, {});
        }
        if (document.getElementById('overtime.pengawas_id')) {
            var element = document.getElementById('overtime.pengawas_id');
            const example = new Choices(element, {});
        }
        if (document.getElementById('overtime.manajer_id')) {
            var element = document.getElementById('overtime.manajer_id');
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
    <script>
        $(document).ready(function() {
            $('#backButton').click(function() {
                window.history.back();
            });
        });
    </script>
@endsection
