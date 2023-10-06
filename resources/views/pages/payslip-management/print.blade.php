

<!DOCTYPE html>
<html lang="en">
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
    $gajiHarian = ((int) $user->gaji / ($totalDate - 4) / 8);
    $overtime = $gajiHarian * $user->overtime;
    $absence = $gajiHarian * $user->absence;
    $bpjs = (2/100) * $user->gaji;
    $totalGross = (int)($user->gaji + $overtime + $user->bonus);
    $totalPotongan = (int)($absence + $bpjs);
    $gajiBersih = $totalGross - $totalPotongan;
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div style="border:1px solid #000; width: 720px;">
        <div style="border-bottom: 1px solid #000; text-align: center; padding: 12px">
            <b>PT. MULTI GEMA ABADI</b><br/>
            <b>SPBU 14.294.707</b><br/>
            Jl. Letjen Suprapto, Bukit Tempayan Batu Aji
        </div>
        <div style="text-align: center; padding:12px">
            <b>SLIP GAJI KARYAWAN</b><br/>
            <u style="text-transform: uppercase">PERIODE {{ $months[$selectedMonth - 1]['option'] }} {{ $selectedYear }}</u>
        </div>
        <div style="padding: 12px">
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
        <div style="padding: 12px">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%">
                        <div style="margin-right: 12px">
                            <b><u>PENGHASILAN</u></b>
                            <table style="width: 100%">
                                <tr>
                                    <td>Gaji Pokok</td>
                                    <td>Rp</td>
                                    <td style="text-align:end;">{{  number_format( $user->gaji, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Lembur</td>
                                    <td>Rp</td>
                                    <td style="text-align:end;">{{  number_format( $overtime, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Bonus</td>
                                    <td>Rp</td>
                                    <td style="text-align:end;">{{  number_format( $user->bonus, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><b>Total</b></td>
                                    <td><b>Rp</b></td>
                                    <td style="text-align:end;"><b>{{  number_format( $totalGross, 0, ',', '.') }}</b></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td style="width: 50%">
                        <div style="margin-left: 12px">
                            <b><u>POTONGAN</u></b>
                            <table style="width: 100%">
                                <tr>
                                    <td>PPh 21</td>
                                    <td>Rp</td>
                                    <td style="text-align: end">0</td>
                                </tr>
                                <tr>
                                    <td>BPJS TK 2%</td>
                                    <td>Rp</td>
                                    <td style="text-align:end;">{{  number_format( $bpjs, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Absence</td>
                                    <td>Rp</td>
                                    <td style="text-align:end;">{{  number_format( $absence, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><b>Total</b></td>
                                    <td><b>Rp</b></td>
                                    <td style="text-align:end;"><b>{{  number_format( $totalPotongan, 0, ',', '.') }}</b></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <br/>
        <div style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding:12px; text-align: center">
            <b>Total Gaji Bersih &emsp; : &emsp; Rp {{  number_format( $gajiBersih, 0, ',', '.') }}</b>
        </div>
        <div style="border-bottom: 1px solid #000; padding:12px; text-align: center; text-transform: capitalize">
            Terbilang &emsp; : &emsp; {{ Terbilang::make($gajiBersih) }} Rupiah
        </div>
        <div style="padding: 12px">
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%">
                        <div style="text-align: center">
                            01-{{ $months[$selectedMonth - 1]['option'] }}-{{ $selectedYear }}<br/>
                            Diserahkan Oleh,
                            <div style="width: 100%; height:100px">
                                <img src="{{ public_path('/assets/img/sign.png') }}" style="max-height: 100%; max-widt: 100%" />
                            </div>
                            <u>Alvenia Nur Primadana</u><br/>
                            <i>Admin</i>
                        </div>
                    </td>
                    <td style="width: 50%">
                        <div style="text-align: center">
                            <br/>
                            Diterima Oleh,
                            <div style="width: 100%; height:100px">
                            </div>
                            <u>{{$user->nama}}</u><br/>
                            <i>{{$user->jabatan}}</i>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>