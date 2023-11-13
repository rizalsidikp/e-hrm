@extends('layouts.user_type.auth')
@php
    $months = [
        [
            'option' => 'Januari',
            'value' => 1
        ],
        [
            'option' => 'Februari',
            'value' => 2
        ],
        [
            'option' => 'Maret',
            'value' => 3
        ],
        [
            'option' => 'April',
            'value' => 4
        ],
        [
            'option' => 'Mei',
            'value' => 5
        ],
        [
            'option' => 'Juni',
            'value' => 6
        ],
        [
            'option' => 'Juli',
            'value' => 7
        ],
        [
            'option' => 'Agustus',
            'value' => 8
        ],
        [
            'option' => 'September',
            'value' => 9
        ],
        [
            'option' => 'Oktober',
            'value' => 10
        ],
        [
            'option' => 'November',
            'value' => 11
        ],
        [
            'option' => 'Desember',
            'value' => 12
        ]
    ]; 
    $selectedMonth = date('n', strtotime($bonus->periode));
    $currentYear = (int) date('Y');
    $years = [$currentYear - 1, (int) $currentYear, $currentYear + 1];
    $selectedYear = date('Y', strtotime($bonus->periode));
@endphp
@section('content')
    <div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Informasi Bonus Pegawai') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bonus.user_id"
                                    class="form-control-label">{{ __('Nama Pegawai') }}</label>
                                <select class="form-control custom-disabled" id="bonus.user_id" name="user_id" disabled>
                                    @foreach ($users as $key => $user)
                                        <option value="{{ $user->id }}"
                                            {{ (int) old('user_id', $bonus->user->id) === $user->id ? 'selected' : '' }}>
                                            {{ $user->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.bonus" class="form-control-label">{{ __('Total Bonus') }}</label>
                                <input class="form-control custom-disabled" type="number" id="user.bonus" name="bonus"
                                    placeholder="500000" value="{{ old('bonus', $bonus->bonus) }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bonus.bulan"
                                    class="form-control-label">{{ __('Bulan') }}</label>
                                <select class="form-control custom-disabled" id="bonus.bulan" name="bulan" disabled>
                                    @foreach ($months as $key => $month)
                                        <option value="{{ $month['value'] }}"
                                            {{ (int) old('month', $selectedMonth) === $month['value'] ? 'selected' : '' }}>
                                            {{ $month['option'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bonus.tahun"
                                    class="form-control-label">{{ __('Tahun') }}</label>
                                <select class="form-control custom-disabled" id="bonus.tahun" name="tahun" disabled>
                                    @foreach ($years as $key => $year)
                                        <option value="{{ $year }}"
                                            {{ (int) old('year', $selectedYear) === $year ? 'selected' : '' }}>
                                            {{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="bonus.deskripsi">{{ 'Deskripsi' }}</label>
                                <textarea class="form-control custom-disabled" style="resize:none" id="bonus.deskripsi" rows="3"
                                    placeholder="deskripsi" name="deskripsi" disabled>{{ old('deskripsi', $bonus->deskripsi) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" id="backButton"
                        class="btn bg-gradient-secondary btn-md mt-4 mb-4">{{ 'Kembali' }}</button>
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
