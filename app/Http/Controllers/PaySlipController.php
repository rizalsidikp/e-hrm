<?php

namespace App\Http\Controllers;

use App\Exports\PayslipsExport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PaySlipController extends Controller
{
    protected $dataPegawai = "Data Penggajian Pegawai";
    public function index(Request $request)
    {
        $selectedMonth = $request->bulan ? $request->bulan : Carbon::now()->month;
        $selectedYear = $request->tahun ? $request->tahun : Carbon::now()->year;
        $date = Carbon::create($selectedYear, $selectedMonth, 1);
        $totalDate = $date->daysInMonth;
        $breadcrumbs = [
            [
                "name" => $this->dataPegawai,
            ]
        ];
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
        return view('pages.payslip-management.index', compact('users', 'breadcrumbs', 'totalDate', 'selectedMonth', 'selectedYear'));
    }

    public function export(Request $request) 
    {
        return Excel::download(new PayslipsExport($request->bulan, $request->tahun), "payslip-$request->bulan-$request->tahun.xlsx");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
