<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use App\Models\User;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    protected $dataLembur = "Data Lembur";
    protected $ovetimeManagementLink = "/overtime-management";
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            [
                "name" => $this->dataLembur,
            ]
        ];
        $overtimes = Overtime::all();
        return view('pages.overtime-management.index', compact('overtimes', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            [
                "name" => $this->dataLembur,

                "link" => $this->ovetimeManagementLink
            ],
            [
                "name" => "Pengajuan Baru",
            ]
        ];
        $users = User::where('id', '!=', '1')->get();
        return view('pages.overtime-management.create', compact('breadcrumbs', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userRole = auth()->user()->role;
        $checkUser = 'required|exists:users,id';
        $rules = [
            'user_id' => $checkUser,
            'tanggal' => 'required|date',
            'shift' => 'required|in:pagi,siang',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'jumlah_operator' => 'required|string',
            'alasan' => 'required|string',
        ];

        // Validasi pengawas_id hanya jika user yang sedang login adalah admin
        if ($userRole === 'admin') {
            $rules['pengawas_id'] = $checkUser;
        }

        // Validasi manajer_id
        $rules['manajer_id'] = $checkUser;

        $request->validate($rules);

        $jamMulai = \Carbon\Carbon::parse($request->jam_mulai);
        $jamSelesai = \Carbon\Carbon::parse($request->jam_selesai);
        $jumlahJam = $jamMulai->diffInHours($jamSelesai);

        $data = [
            'user_id' => (int) $request->user_id,
            'tanggal' => $request->tanggal,
            'shift' => $request->shift,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'jumlah_jam' => $jumlahJam,
            'pengawas_id' => $request->pengawas_id,
            'manajer_id' => $request->manajer_id,
            'jumlah_operator' => $request->jumlah_operator,
            'alasan' => $request->alasan,
        ];

        $overtime = new Overtime($data);
        $overtime->save();
        return redirect($this->ovetimeManagementLink)->with('success', 'Pengajuan berhasil ditambah');
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