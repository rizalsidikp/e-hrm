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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="absence.user_id" class="form-control-label">{{ __('Nama Pegawai') }}</label>
                                <input id="absence.tanggal_mulai" name="tanggal_mulai" class="form-control custom-disabled"
                                    type="text" value="{{ $absence->user->nama }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="absence.status" class="form-control-label">{{ __('Jenis Pengajuan') }}</label>
                                <select class="form-control custom-disabled" id="absence.status" name="status" disabled>
                                    <option value="izin" {{ $absence->status === 'izin' ? 'selected' : '' }}>
                                        Izin</option>
                                    <option value="sakit" {{ $absence->status === 'sakit' ? 'selected' : '' }}>
                                        Sakit</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="absence.tipe" class="form-control-label">{{ __('Tipe Pengajuan') }}</label>
                                <select class="form-control custom-disabled" id="absence.tipe" name="tipe" disabled>
                                    <option value="hari" {{ $absence->tipe === 'hari' ? 'selected' : '' }}>
                                        Hari</option>
                                    <option value="jam" {{ $absence->tipe === 'jam' ? 'selected' : '' }}>
                                        Jam</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="absence.tanggal_mulai"
                                    class="form-control-label">{{ __('Tanggal Mulai') }}</label>
                                <input id="absence.tanggal_mulai" name="tanggal_mulai" class="form-control custom-disabled"
                                    placeholder="Please select date" type="text" value="{{ $absence->tanggal_mulai }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="absence.tanggal_selesai"
                                    class="form-control-label">{{ __('Tanggal Selesai') }}</label>
                                <input id="absence.tanggal_selesai" name="tanggal_selesai"
                                    class="form-control custom-disabled" placeholder="Please select date" type="text"
                                    value="{{ $absence->tanggal_selesai }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="absence.tanggal" class="form-control-label">{{ __('Tanggal') }}</label>
                                <input id="absence.tanggal" name="tanggal" class="form-control custom-disabled"
                                    placeholder="Please select date" type="text" value="{{ $absence->tanggal_mulai }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="form-jam">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="absence.jam_mulai" class="form-control-label">{{ __('Jam Mulai') }}</label>
                                <input id="absence.jam_mulai" name="jam_mulai" class="form-control custom-disabled"
                                    placeholder="Please select date" type="text" value="{{ $absence->jam_mulai }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="absence.jam_selesai" class="form-control-label">{{ __('Jam Selesai') }}</label>
                                <input id="absence.jam_selesai" name="jam_selesai" class="form-control custom-disabled"
                                    placeholder="Please select date" type="text" value="{{ $absence->jam_selesai }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="absence.alasan">{{ 'alasan' }}</label>
                            <textarea class="form-control custom-disabled" style="resize:none" id="absence.alasan" rows="3"
                                placeholder="Alasan Izin / Sakit" name="alasan" disabled>{{ $absence->alasan }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="absence.pemotongan"
                                    class="form-control-label">{{ __('Pemotongan Gaji') }}</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input absence_pemotongan cursor-default" type="checkbox"
                                        name="pemotongan" id="absence.pemotongan"
                                        {{ $absence->pemotongan ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="absence.bukti"
                                    class="form-control-label">{{ __('Bukti Izin / Sakit') }}</label><br />
                                @if ($absence->bukti)
                                    @php
                                        $text = $absence->bukti;
                                        $parts = explode('/', $text);
                                        $result = end($parts);
                                    @endphp
                                    <label class="font-weight-normal cursor-pointer custom-text-hover"
                                        data-bs-toggle="modal" data-bs-target="#absenceBukti"
                                        data-image="{{ $absence->bukti }}">{{ $result }}
                                        (click to
                                        preview)</label>
                                @else
                                    <label>-</label>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="absenceBukti" tabindex="-1" role="dialog" aria-labelledby="absenceBuktiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="absenceBuktiLabel">Bukti Sakit / Izin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img alt="bukti" src="" class="mw-100" id="imgAbsenceBukti" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-content')
    <script>
        $(document).ready(function() {
            $('.absence_pemotongan').click(function(event) {
                event.preventDefault()
            })
        })
    </script>
    <script>
        $('#absenceBukti').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var image = button.data('image');
            var modal = $(this);
            var urlGambar = "{{ asset('') }}" + image;
            $('#imgAbsenceBukti').attr('src', urlGambar)
        });
    </script>
@endsection
