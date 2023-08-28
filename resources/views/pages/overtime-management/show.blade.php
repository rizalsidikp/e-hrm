@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Informasi Pengajuan') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="overtime.user_id" class="form-control-label">{{ __('Nama Pegawai') }}</label>
                                <input class="form-control custom-disabled" id="overtime.user_id" name="user_id"
                                    value="{{ $overtime->user->nama }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="overtime.persetujuan_user"
                                    class="form-control-label">{{ __('Persetujuan Pegawai') }}</label>
                                <input
                                    class="form-control custom-disabled text-capitalize @if ($overtime->approved_user === 'disetujui') is-valid @elseif($overtime->approved_user === 'ditolak') is-invalid @endif"
                                    id="overtime.persetujuan_user" name="persetujuan_user"
                                    value="{{ $overtime->approved_user }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="overtime.tanggal" class="form-control-label">{{ __('Tanggal') }}</label>
                                <input id="overtime.tanggal" name="tanggal" class="form-control datepicker custom-disabled"
                                    placeholder="Please select date" type="text" value="{{ $overtime->tanggal }}"
                                    onfocus="focused(this)" onfocusout="defocused(this)" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="overtime.shift" class="form-control-label">{{ __('Shift') }}</label>
                                <select class="form-control custom-disabled" id="overtime.shift" name="shift" disabled>
                                    <option value="pagi" {{ $overtime->shift === 'pagi' ? 'selected' : '' }}>
                                        Pagi</option>
                                    <option value="siang" {{ $overtime->shift === 'siang' ? 'selected' : '' }}>
                                        Siang</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="overtime.jam_mulai" class="form-control-label">{{ __('Jam Mulai') }}</label>
                                <input id="overtime.jam_mulai" name="jam_mulai" class="form-control timepicker"
                                    placeholder="Please select date" type="text" value="{{ $overtime->jam_mulai }}"
                                    onfocus="focused(this)" onfocusout="defocused(this)" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="overtime.jam_selesai"
                                    class="form-control-label">{{ __('Jam Selesai') }}</label>
                                <input id="overtime.jam_selesai" name="jam_selesai" class="form-control timepicker"
                                    placeholder="Please select date" type="text" value="{{ $overtime->jam_selesai }}"
                                    onfocus="focused(this)" onfocusout="defocused(this)" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="overtime.pengawas_id"
                                    class="form-control-label">{{ __('Nama Pengawas') }}</label>
                                <input class="form-control custom-disabled" id="overtime.pengawas_id" name="pengawas_id"
                                    value="{{ $overtime->pengawas->nama }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="overtime.manajer_id"
                                    class="form-control-label">{{ __('Nama Manajer') }}</label>
                                <input class="form-control custom-disabled" id="overtime.manajer_id" name="manajer_id"
                                    value="{{ $overtime->manajer->nama }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="overtime.persetujuan_pengawas"
                                    class="form-control-label">{{ __('Persetujuan Pengawas') }}</label>
                                <input
                                    class="form-control custom-disabled text-capitalize @if ($overtime->approved_pengawas === 'disetujui') is-valid @elseif($overtime->approved_pengawas === 'ditolak') is-invalid @endif"
                                    id="overtime.persetujuan_pengawas" name="persetujuan_pengawas"
                                    value="{{ $overtime->approved_pengawas }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="overtime.persetujuan_manajer"
                                    class="form-control-label">{{ __('Persetujuan Manajer') }}</label>
                                <input
                                    class="form-control custom-disabled text-capitalize @if ($overtime->approved_manajer === 'disetujui') is-valid @elseif($overtime->approved_manajer === 'ditolak') is-invalid @endif"
                                    id="overtime.persetujuan_manajer" name="persetujuan_manajer"
                                    value="{{ $overtime->approved_manajer }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="overtime.jumlah_operator"
                                    class="form-control-label">{{ __('Jumlah Operator') }}</label>
                                <input class="form-control custom-disabled" type="text" placeholder="Jumlah Operator"
                                    id="overtime.jumlah_operator" name="jumlah_operator"
                                    value="{{ $overtime->jumlah_operator }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="overtime.alasan"
                                    class="form-control-label">{{ __('Alasan Memberi Perintah OT') }}</label>
                                <input class="form-control custom-disabled" type="text"
                                    placeholder="Alasan Memberi Perintah OT" id="overtime.alasan" name="alasan"
                                    value="{{ $overtime->alasan }}" disabled>
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
        $(document).ready(function() {
            $('#backButton').click(function() {
                window.history.back();
            });
        });
    </script>
@endsection
