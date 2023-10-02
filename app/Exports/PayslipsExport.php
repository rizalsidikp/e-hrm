<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class PayslipsExport implements FromView, ShouldAutoSize, WithColumnFormatting
{
    protected $bulan;
    protected $tahun;
    public function __construct(string $bulan, string $tahun) {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $selectedMonth = $this->bulan;
        $selectedYear = $this->tahun;
        $date = Carbon::create($selectedYear, $selectedMonth, 1);
        $totalDate = $date->daysInMonth;
        $users = User::leftJoin(DB::raw("(SELECT user_id, COALESCE(SUM(jumlah_jam), 0) as total_overtime FROM overtimes WHERE MONTH(tanggal) = $selectedMonth AND YEAR(tanggal) = $selectedYear AND approved_pengawas = 'disetujui' AND approved_manajer = 'disetujui' AND deleted_at IS NULL GROUP BY user_id) as overtime"), 'users.id', '=', 'overtime.user_id')
        ->leftJoin(DB::raw("(SELECT user_id, COALESCE(SUM(jumlah_jam), 0) as total_absence FROM absences WHERE MONTH(tanggal_mulai) = $selectedMonth AND YEAR(tanggal_mulai) = $selectedYear AND approved = 'disetujui' AND pemotongan = true AND deleted_at IS NULL GROUP BY user_id) as absence"), 'users.id', '=', 'absence.user_id')
        ->leftJoin(DB::raw("(SELECT user_id, COALESCE(SUM(bonus), 0) as total_bonus FROM bonuses WHERE MONTH(periode) = $selectedMonth AND YEAR(periode) = $selectedYear AND deleted_at IS NULL GROUP BY user_id) as bonus"), 'users.id', '=', 'bonus.user_id')
        ->select('users.id', 'users.nama', 'users.jabatan', 'users.gaji', 
            DB::raw('COALESCE(SUM(overtime.total_overtime), 0) as overtime'),
            DB::raw('COALESCE(SUM(absence.total_absence), 0) as absence'),
            DB::raw('COALESCE(SUM(bonus.total_bonus), 0) as bonus')
        )
        ->where('users.id', '<>', '1')
        ->groupBy('users.id', 'users.nama', 'users.jabatan', 'users.gaji')
        ->get();
        return view('pages.payslip-management.export', compact('users', 'totalDate', 'selectedMonth', 'selectedYear'));
    }
    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'L' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
}
