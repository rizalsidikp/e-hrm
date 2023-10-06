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
    $currentYear = (int) date('Y');
    $years = [$currentYear];
    for($i = 1; $i < 10; $i++){
        array_push($years, $currentYear - $i);
    }
    $filteredMonths = array_filter($months, function($month) use ($selectedMonth) {
        return $month['value'] == $selectedMonth;
    });

    if(!!$user){
        $gajiHarian = ((int) $user->gaji / ($totalDate - 4) / 8);
        $overtime = $gajiHarian * $user->overtime;
        $absence = $gajiHarian * $user->absence;
        $bpjs = (2/100) * $user->gaji;
        $totalGross = (int)($user->gaji + $overtime + $user->bonus);
        $totalPotongan = (int)($absence + $bpjs);
        $gajiBersih = $totalGross - $totalPotongan;
    }
@endphp
@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                @if (session('error'))
                    <div class="mt-3 mb-4 mx-4 alert alert-primary alert-dismissible fade show" role="alert">
                        <span class="alert-text text-white">
                            {{ session('error') }}</span>
                        <button type="button" class="btn-close p-3" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif
                @if (session('success'))
                    <div class="m-3 mb-4 mx-4 alert alert-success alert-dismissible fade show" id="alert-success"
                        role="alert">
                        <span class="alert-text text-white">
                            {{ session('success') }}</span>
                        <button type="button" class="btn-close p-3" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Payslip Saya</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row p-4 justify-content-between">
                            <div class="col-md-8">
                                <form method="GET" action="/payslip">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control cursor-pointer" id="bonus.bulan" name="bulan" required>
                                                    @foreach ($months as $key => $month)
                                                        <option value="{{ $month['value'] }}"
                                                            {{ (int) $selectedMonth === $month['value'] ? 'selected' : '' }}>
                                                            {{ $month['option'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <select class="form-control cursor-pointer" id="bonus.tahun" name="tahun" required>
                                                    @foreach ($years as $key => $year)
                                                        <option value="{{ $year }}"
                                                            {{ (int) $selectedYear === $year ? 'selected' : '' }}>
                                                            {{ $year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn bg-gradient-primary mb-0 w-100">
                                                    Filter
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @if(!!$user)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <a href="/payslip/print?bulan={{$selectedMonth}}&tahun={{$selectedYear}}" class="btn bg-gradient-info mb-0 w-100">
                                        Print To PDF
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="row justify-content-center mb-4">
                            @if(!!$user)
                            <div class="col-md-8" style="border:1px solid #000">
                                <div class="row">
                                    <div class="col-md-12 text-center p-2" style="border-bottom: 1px solid #000">
                                        <b>PT. MULTI GEMA ABADI</b><br/>
                                        <b>SPBU 14.294.707</b><br/>
                                        Jl. Letjen Suprapto, Bukit Tempayan Batu Aji
                                    </div>
                                    <div class="col-md-12 text-center p-2">
                                        <b>SLIP GAJI KARYAWAN</b><br/>
                                        <u class="text-uppercase">PERIODE {{ $months[$selectedMonth - 1]['option'] }} {{ $selectedYear }}</u>
                                    </div>
                                    <div class="col-md-12 py-2 px-4">
                                        <table>
                                            <tr>
                                                <td style="width:96px">Nama</td><td style="width: 20px">:</td><td>{{ $user->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width:96px">Jabatan</td><td style="width: 20px">:</td><td>{{ $user->jabatan }}</td>
                                            </tr>
                                        </table>
                                        <br/>
                                    </div>
                                    <div class="col-md-6 py-2 px-4">
                                        <b><u>PENGHASILAN</u></b>
                                        <table class="w-100">
                                            <tr>
                                                <td>Gaji Pokok</td>
                                                <td>Rp</td>
                                                <td class="text-end">{{  number_format( $user->gaji, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Lembur</td>
                                                <td>Rp</td>
                                                <td class="text-end">{{  number_format( $overtime, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Bonus</td>
                                                <td>Rp</td>
                                                <td class="text-end">{{  number_format( $user->bonus, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b>Rp</b></td>
                                                <td class="text-end"><b>{{  number_format( $totalGross, 0, ',', '.') }}</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6 py-2 px-4">
                                        <b><u>POTONGAN</u></b>
                                        <table class="w-100">
                                            <tr>
                                                <td>PPh 21</td>
                                                <td>Rp</td>
                                                <td class="text-end">0</td>
                                            </tr>
                                            <tr>
                                                <td>BPJS TK 2%</td>
                                                <td>Rp</td>
                                                <td class="text-end">{{  number_format( $bpjs, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Absence</td>
                                                <td>Rp</td>
                                                <td class="text-end">{{  number_format( $absence, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Total</b></td>
                                                <td><b>Rp</b></td>
                                                <td class="text-end"><b>{{  number_format( $totalPotongan, 0, ',', '.') }}</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <br/>
                                    <div class="col-md-12 py-2 px-4 text-center" style="border-top: 1px solid #000; border-bottom: 1px solid #000">
                                        <b>Total Gaji Bersih &emsp; : &emsp; Rp {{  number_format( $gajiBersih, 0, ',', '.') }}</b>
                                    </div>
                                    <div class="col-md-12 py-2 px-4 text-center text-capitalize" style="border-bottom: 1px solid #000">
                                        Terbilang &emsp; : &emsp; {{ Terbilang::make($gajiBersih) }} Rupiah
                                    </div>
                                    <div class="col-md-6 text-center py-2 px-4">
                                        01-{{ $months[$selectedMonth - 1]['option'] }}-{{ $selectedYear }}<br/>
                                        Diserahkan Oleh,
                                        <div style="width: 100%; height:100px">
                                            <img src="{{ asset('assets/img/sign.png') }}" style="max-height: 100%; max-widt: 100%" />
                                        </div>
                                        <u>Alvenia Nur Primadana</u><br/>
                                        <i>Admin</i>
                                    </div>
                                    <div class="col-md-6 text-center py-2 px-4">
                                        <br/>
                                        Diterima Oleh,
                                        <div style="width: 100%; height:100px">
                                        </div>
                                        <u>{{$user->nama}}</u><br/>
                                        <i>{{$user->jabatan}}</i>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="col-md-8 p-5 text-center">
                                Data Belum Tersedia
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-content') 
@endsection
