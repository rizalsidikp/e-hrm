<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $dataAbsensi = "Data Absensi";
    protected $absenceManagementLink = "/absence-management";

    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }
    public function index()
    {
        $breadcrumbs = [
            [
                "name" => $this->dataAbsensi,
            ]
        ];
        $absences = Absence::with(['user', 'userApproved'])->orderBy("id", "desc")->get();
        return view('pages.absence-management.index', compact('absences', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            [
                "name" => $this->dataAbsensi,

                "link" => $this->absenceManagementLink
            ],
            [
                "name" => "Pengajuan Baru",
            ]
        ];
        $users = User::where('id', '!=', '1')->get();
        return view('pages.absence-management.create', compact('breadcrumbs', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            // Pastikan user_id valid dan ada dalam tabel users
            'status' => 'required|in:izin,sakit',
            'tipe' => 'required|in:hari,jam',
            'tanggal_mulai' => 'required_if:tipe,hari|nullable|date',
            'tanggal_selesai' => 'required_if:tipe,hari|nullable|date|after_or_equal:tanggal_mulai',
            'tanggal' => 'required_if:tipe,jam|nullable|date',
            'jam_mulai' => 'required_if:tipe,jam|nullable|date_format:H:i',
            'jam_selesai' => 'required_if:tipe,jam|nullable|date_format:H:i|after:jam_mulai',
            'alasan' => 'required|string',
            'pemotongan' => 'in:on',
            'bukti' => 'required_if:status,sakit',
        ]);



        $jumlahJam = 0;

        if ($request['tipe'] === 'hari') {
            $tanggalMulai = \Carbon\Carbon::parse($request->tanggal_mulai);
            $tanggalSelesai = \Carbon\Carbon::parse($request->tanggal_selesai);
            $jumlahJam = ($tanggalMulai->diffInDays($tanggalSelesai) + 1) * 8;
        } elseif ($request['tipe'] === 'jam') {
            $jamMulai = \Carbon\Carbon::parse($request->jam_mulai);
            $jamSelesai = \Carbon\Carbon::parse($request->jam_selesai);
            $jumlahJam = $jamMulai->diffInHours($jamSelesai);
        }
        $isValidFile = false;
        if ($request->bukti) {
            $newFilePath = $request->bukti;
            $originalFilePath = 'images/bukti/temp-' . Str::afterLast($newFilePath, '/');
            if (file_exists(public_path($originalFilePath))) {
                $isValidFile = true;
                // Ubah nama file
                File::move(public_path($originalFilePath), public_path($newFilePath));

                // Hapus semua file dengan awalan "temp-"
                $tempFiles = File::glob(public_path('images/bukti/temp-*'));
                foreach ($tempFiles as $tempFile) {
                    File::delete($tempFile);
                }
            }

        }

        $data = [
            'user_id' => (int) $request->user_id,
            'status' => $request->status,
            'tipe' => $request->tipe,
            'tanggal_mulai' => $request->tipe === 'jam' ? $request->tanggal : $request->tanggal_mulai,
            'tanggal_selesai' => $request->tipe === 'jam' ? $request->tanggal : $request->tanggal_selesai,
            'jam_mulai' => $request->tipe === 'hari' ? null : $request->jam_mulai,
            'jam_selesai' => $request->tipe === 'hari' ? null : $request->jam_selesai,
            'jumlah_jam' => $jumlahJam,
            'alasan' => $request->alasan,
            'approved' => Auth::user()->role === 'admin' ? 'disetujui' : 'butuh persetujuan',
            'approved_by' => Auth::user()->role === 'admin' ? Auth::user()->id : null,
            'pemotongan' => $request->pemotongan ? true : false,
            'bukti' => $isValidFile ? $request->bukti : null,
        ];

        $absence = new Absence($data);
        $absence->save();
        return redirect($this->absenceManagementLink)->with('success', 'Pengajuan berhasil ditambah');
    }

    public function uploadBukti(Request $request)
    {
        if ($request->hasFile('bukti')) {
            $bukti = null;
            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $fileNameWithTemp = "temp-" . $fileName;
                $folderPath = public_path('images/bukti');

                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0755, true);
                }

                $filePath = $folderPath . '/' . $fileNameWithTemp;
                if (move_uploaded_file($file->getPathname(), $filePath)) {
                    $bukti = 'images/bukti/' . $fileName;
                    $response = ['bukti' => $bukti];
                    return response()->json($response);
                }
            }
        }
        return response()->json(['message' => 'Gagal mengunggah berkas.'], 400);
    }

    public function approved(Request $request, string $id)
    {
        $request->validate([
            'approved' => 'required|in:ditolak,disetujui,butuh persetujuan',
        ]);
        $absence = Absence::find($id);
        if (!$absence) {
            return redirect($this->absenceManagementLink)->with('error', 'Pengajuan tidak ditemukan');
        }
        $absence->update([
            'approved' => $request->approved,
            'approved_by' => auth()->user()->id
        ]);
        return redirect($this->absenceManagementLink)->with(
            'success',
            $request->approved === "butuh persetujuan" ?
            'Persetujuan pengajuan berhasil dibatalkan'
            :
            'Pengajuan berhasil ' . $request->approved
        );
    }
    public function pemotongan(Request $request, string $id)
    {
        $request->validate([
            'pemotongan' => 'required|in:1,0',
        ]);
        $absence = Absence::find($id);
        if (!$absence) {
            return redirect($this->absenceManagementLink)->with('error', 'Pengajuan tidak ditemukan');
        }
        $absence->update([
            'pemotongan' => !$request->pemotongan
        ]);
        return redirect($this->absenceManagementLink)->with('success', 'Pengajuan berhasil diperbarui');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $breadcrumbs = [
            [
                "name" => $this->dataAbsensi,
                "link" => $this->absenceManagementLink
            ],
            [
                "name" => "Detail Data Pegawai",
            ]
        ];
        $absence = Absence::find($id);
        if (!$absence) {
            return redirect($this->absenceManagementLink)->with('error', 'Pengajuan tidak ditemukan.');
        }

        return view('pages.absence-management.show', compact('absence', 'breadcrumbs'));
    }
}