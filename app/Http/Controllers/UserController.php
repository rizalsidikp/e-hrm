<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $dataPegawai = "Data Pegawai";
    protected $userManagementLink = "/user-management";
    protected $notFoundMessage = "Data pegawai tidak ditemukan.";
    protected $requiredWithMax50 = "required|max:50";
    protected $requiredWithDate = "required|date";
    public function __construct()
    {
        $this->middleware('checkRole:admin,superadmin');
    }
    public function index()
    {
        $breadcrumbs = [
            [
                "name" => $this->dataPegawai,
            ]
        ];
        $users = User::where('id', '!=', 1)->get();
        return view('pages.user-management.index', compact('users', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            [
                "name" => $this->dataPegawai,

                "link" => $this->userManagementLink
            ],
            [
                "name" => "Pegawai Baru",
            ]
        ];
        return view('pages.user-management.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required|email|max:50|unique:users,email',
            'username'=> 'required',
            'jabatan' => $this->requiredWithMax50,
            'jenis_kelamin' => 'required|in:l,p',
            'tempat_lahir' => $this->requiredWithMax50,
            'tanggal_lahir' => $this->requiredWithDate,
            'alamat' => 'max:255',
            'no_hp' => 'max:20',
            'status' => 'required|in:On Job Training,Kontrak,Permanen',
            'mulai_bekerja' => $this->requiredWithDate,
            'gaji' => 'required|numeric',
            'role' => 'in:superadmin,admin,manajer,pengawas,user',
            'password' => 'required|min:8|confirmed'
        ]);
        $user = new User();
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->jabatan = $request->jabatan;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->no_hp;
        $user->status = $request->status;
        $user->mulai_bekerja = $request->mulai_bekerja;
        $user->gaji = $request->gaji;
        $user->role = $request->role;
        $user->save();

        return redirect($this->userManagementLink)->with('success', 'Data pegawai berhasil ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $breadcrumbs = [
            [
                "name" => $this->dataPegawai,
                "link" => $this->userManagementLink
            ],
            [
                "name" => "Ubah Data Pegawai",
            ]
        ];
        $user = User::where('id', '!=', 1)->find($id);
        if (!$user) {
            return redirect($this->userManagementLink)->with('error', $this->notFoundMessage);
        }

        return view('pages.user-management.edit', compact('user', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('id', '!=', 1)->find($id);
        if (!$user) {
            return redirect($this->userManagementLink)->with('error', $this->notFoundMessage);
        }
        $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required|email|max:50|unique:users,email,' . $id,
            'username'=> 'required',
            'jabatan' => $this->requiredWithMax50,
            'jenis_kelamin' => 'required|in:l,p',
            'tempat_lahir' => $this->requiredWithMax50,
            'tanggal_lahir' => $this->requiredWithDate,
            'alamat' => 'max:255',
            'no_hp' => 'max:20',
            'status' => 'required|in:On Job Training,Kontrak,Permanen',
            'mulai_bekerja' => $this->requiredWithDate,
            'gaji' => 'required|numeric',
            'role' => 'in:superadmin,admin,manajer,pengawas,user',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('current_password') && !Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini tidak cocok.');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->jabatan = $request->jabatan;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->no_hp;
        $user->status = $request->status;
        $user->mulai_bekerja = $request->mulai_bekerja;
        $user->gaji = $request->gaji;
        $user->role = $request->role;
        $user->save();

        return redirect($this->userManagementLink)->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', '!=', 1)->find($id);
        if ($user) {
            $user->delete(); // Soft delete data
            return redirect()->back()->with('success', 'Data pegawai berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', $this->notFoundMessage);
        }
    }
}