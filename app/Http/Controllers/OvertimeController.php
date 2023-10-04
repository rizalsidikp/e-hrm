<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use App\Models\User;
use Illuminate\Http\Request;


class OvertimeController extends Controller
{
    protected $dataLembur;
    protected $ovetimeManagementLink;
    protected $userMenu;
    protected $menuUrl;
    public function __construct()
    {
        $currentRoute = app('router')->getCurrentRoute();
        $routeName = $currentRoute->getName();
        $routeParts = explode('.', $routeName);
        $this->menuUrl = $routeParts[0];

        $this->middleware('checkRole:admin,superadmin,pengawas')->only(['create', 'store']);
        $this->userMenu = $this->menuUrl === 'overtime';
        $this->dataLembur = $this->userMenu ? "Lembur Saya" : "Data Absensi";
        $this->ovetimeManagementLink = '/' . $this->menuUrl;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ($this->redirectToUserPage()) {
            return redirect('/overtime');
        }
        $breadcrumbs = [
            [
                "name" => $this->dataLembur,
            ]
        ];
        if ($this->userMenu) {
            $overtimes = Overtime::where('user_id', auth()->user()->id)->orderBy("id", "desc")->get();
        } else {
            if (auth()->user()->role === 'manajer') {
                $overtimes = Overtime::where('manajer_id', auth()->user()->id)->orderBy("id", "desc")->get();
            } elseif (auth()->user()->role === 'pengawas') {
                $overtimes = Overtime::where('pengawas_id', auth()->user()->id)->orderBy("id", "desc")->get();
            } else {
                $overtimes = Overtime::orderBy("id", "desc")->get();
            }
        }
        return view('pages.overtime-management.index', compact('overtimes', 'breadcrumbs'))->with('menuUrl', $this->menuUrl);
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
        $users = User::where('role', '<>', 'superadmin')->get();
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
        if ($userRole === 'admin' || $userRole === 'superadmin') {
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
            'pengawas_id' => auth()->user()->role === 'pengawas' ? auth()->user()->id : $request->pengawas_id,
            'manajer_id' => $request->manajer_id,
            'jumlah_operator' => $request->jumlah_operator,
            'alasan' => $request->alasan,
        ];

        if (auth()->user()->role === 'pengawas') {
            $data['approved_pengawas'] = 'disetujui';
        }

        $overtime = new Overtime($data);
        $overtime->save();
        return redirect($this->ovetimeManagementLink)->with('success', 'Pengajuan berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $breadcrumbs = [
            [
                "name" => $this->dataLembur,
                "link" => $this->ovetimeManagementLink
            ],
            [
                "name" => "Detail Pengajuan Izin & Sakit",
            ]
        ];
        $overtime = Overtime::find($id);
        if (!$overtime) {
            return redirect($this->ovetimeManagementLink)->with('error', 'Pengajuan tidak ditemukan.');
        }

        return view('pages.overtime-management.show', compact('overtime', 'breadcrumbs'));
    }
    protected function redirectToUserPage()
    {
        $role = auth()->user()->role;
        if (!$this->userMenu && $role === 'user') {
            return true;
        }
        return false;
    }

    public function approved(Request $request, string $id)
    {
        $pengajuanTidakDitemukan = 'Pengajuan tidak ditemukan';
        $request->validate([
            'approved' => 'required|in:ditolak,disetujui,butuh persetujuan',
            'by' => 'required|in:user,pengawas,manajer'
        ]);
        if ($request->by === 'user') {
            $overtime = Overtime::where('user_id', auth()->user()->id)->find($id);
            if (!$overtime) {
                return redirect($this->ovetimeManagementLink)->with('error', $pengajuanTidakDitemukan);
            }
            $overtime->update([
                'approved_user' => $request->approved,
            ]);
        } elseif ($request->by === 'pengawas') {
            $overtime = Overtime::where('pengawas_id', auth()->user()->id)->find($id);
            if (!$overtime) {
                return redirect($this->ovetimeManagementLink)->with('error', $pengajuanTidakDitemukan);
            }
            $overtime->update([
                'approved_pengawas' => $request->approved,
            ]);
        } elseif ($request->by === 'manajer') {
            $overtime = Overtime::where('manajer_id', auth()->user()->id)->find($id);
            if (!$overtime) {
                return redirect($this->ovetimeManagementLink)->with('error', $pengajuanTidakDitemukan);
            }
            $overtime->update([
                'approved_manajer' => $request->approved,
            ]);
        }

        return redirect($this->ovetimeManagementLink)->with(
            'success',
            $request->approved === "butuh persetujuan" ?
            'Persetujuan pengajuan berhasil dibatalkan'
            :
            'Pengajuan berhasil ' . $request->approved
        );
    }
}