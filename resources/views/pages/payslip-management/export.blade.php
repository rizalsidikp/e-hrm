<table>
    <caption></caption>
    <thead>
        <tr>
            <th style="font-weight: bold; border:1px solid #000 text-align:center">
                No
            </th>
            <th style="font-weight: bold; border:1px solid #000 text-align:center">
                Nama
            </th>
            <th style="font-weight: bold; border:1px solid #000 text-align:center">
                Jabatan
            </th>
            <th style="font-weight: bold; border:1px solid #000 text-align:center">
                Jumlah Hari Kerja <br/>
                Shift Normal
            </th>
            <th style="font-weight: bold; border:1px solid #000 text-align:center">
                Gaji Pokok
            </th>
            <th style="font-weight: bold; border:1px solid #000 text-align:center">
                Over Time <br/>
                (Jumlah Jam)
            </th>
            <th style="font-weight: bold; border:1px solid #000 text-align:center">
                Over Time <br/>
                (Jumlah Rupiah)
            </th>
            <th style="font-weight: bold; border:1px solid #000 text-align:center">
                Bonus
            </th>
            <th style="font-weight: bold; border:1px solid #000 text-align:center">
                Absence <br/>
                (Jumlah Jam)
            </th>
            <th style="font-weight: bold; border:1px solid #000 text-align:center">
                Absence <br/>
                (Jumlah Rupiah)
            </th>
            <th style="font-weight: bold; border:1px solid #000 text-align:center">
                BPJS TK <br/>
                (2%)
            </th>
            <th style="font-weight: bold; border:1px solid #000 text-align:center">
                Pendapatan Bersih
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key => $user)
            @php
                $gajiHarian = ($user->gaji / ($totalDate - 4) / 8);
                $overtime = $gajiHarian * $user->overtime;
                $absence = $gajiHarian * $user->absence;
                $bpjs = ((2/100) * $user->gaji);
                $gajiBersih = $user->gaji + (int) $overtime + $user->bonus - (int) $absence - (int) $bpjs;
            @endphp
            <tr>
                <td style="border: 1px solid #000">
                    {{ $key + 1 }}
                </td>
                <td style="border: 1px solid #000">
                    {{ $user->nama }}
                </td>
                <td style="border: 1px solid #000">
                    {{ $user->jabatan }}
                </td>
                <td style="border: 1px solid #000">
                    {{ $totalDate - 4 }}
                </td>
                <td style="border: 1px solid #000">
                    {{  $user->gaji }}
                </td>
                <td style="border: 1px solid #000">
                    {{ $user->overtime }}
                </td>
                <td style="border: 1px solid #000">
                    {{ (int) $overtime }}
                </td>
                <td style="border: 1px solid #000">
                    {{ (int) $user->bonus }}
                </td>
                <td style="border: 1px solid #000">
                    {{ $user->absence }}
                </td>
                <td style="border: 1px solid #000">
                    {{ (int) $absence }}
                </td>
                <td style="border: 1px solid #000">
                    {{ (int) $bpjs }}
                </td>
                <td style="border: 1px solid #000">
                    {{ (int) $gajiBersih }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>