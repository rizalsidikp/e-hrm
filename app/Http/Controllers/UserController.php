<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $dataPegawai = "Data Pegawai";
    protected $userManagementLink = "/user-management";
    protected $notFoundMessage = "Data pegawai tidak ditemukan.";
    public function __construct()
    {
        $this->middleware('checkRole:admin');
    }
    public function index()
    {
        $breadcrumbs = [
            [
                "name" => $this->dataPegawai,
            ]
        ];
        $users = User::where('role', '!=', 'admin')->get();
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
        $max50 = 'max:50';
        $attributes = request()->validate([
            'nama' => ['required', 'max:100'],
            'email' => ['required', 'email', $max50, Rule::unique('users')],
            'jabatan' => ['required', $max50],
            'jenis_kelamin' => ['required', 'in:l,p'],
            'tempat_lahir' => ['required', $max50],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['max:255'],
            'no_hp' => ['max:20'],
            'status' => ['required', 'in:On Job Training,Kontrak,Permanen'],
            'mulai_bekerja' => ['required', 'date'],
            'gaji' => ['required', 'numeric'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);
        $user = new User();
        $user->nama = $attributes['nama'];
        $user->email = $attributes['email'];
        $user->password = Hash::make($attributes['password']); // Ingat untuk mengenkripsi password
        $user->jabatan = $attributes['jabatan'];
        $user->jenis_kelamin = $attributes['jenis_kelamin'];
        $user->tempat_lahir = $attributes['tempat_lahir'];
        $user->tanggal_lahir = $attributes['tanggal_lahir'];
        $user->alamat = $attributes['alamat'];
        $user->no_hp = $attributes['no_hp'];
        $user->status = $attributes['status'];
        $user->mulai_bekerja = $attributes['mulai_bekerja'];
        $user->gaji = $attributes['gaji'];
        $user->role = 'user';
        $user->save();

        return redirect($this->userManagementLink)->with('success', 'Data pegawai berhasil ditambah');
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
        $breadcrumbs = [
            [
                "name" => $this->dataPegawai,
                "link" => $this->userManagementLink
            ],
            [
                "name" => "Ubah Data Pegawai",
            ]
        ];
        $user = User::where('role', 'user')->find($id);
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
        $user = User::find($id);
        if (!$user) {
            return redirect($this->userManagementLink)->with('error', $this->notFoundMessage);
        }

        $max50 = 'max:50';
        $attributes = request()->validate([
            'nama' => ['required', 'max:100'],
            'email' => ['required', 'email', $max50, 'unique:users,email,' . $id],
            'jabatan' => ['required', $max50],
            'jenis_kelamin' => ['required', 'in:l,p'],
            'tempat_lahir' => ['required', $max50],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['max:255'],
            'no_hp' => ['max:20'],
            'status' => ['required', 'in:On Job Training,Kontrak,Permanen'],
            'mulai_bekerja' => ['required', 'date'],
            'gaji' => ['required', 'numeric'],
            'current_password' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($request->filled('current_password') && !Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini tidak cocok.');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($attributes['password']);
        }
        $user->nama = $attributes['nama'];
        $user->email = $attributes['email'];
        $user->jabatan = $attributes['jabatan'];
        $user->jenis_kelamin = $attributes['jenis_kelamin'];
        $user->tempat_lahir = $attributes['tempat_lahir'];
        $user->tanggal_lahir = $attributes['tanggal_lahir'];
        $user->alamat = $attributes['alamat'];
        $user->no_hp = $attributes['no_hp'];
        $user->status = $attributes['status'];
        $user->mulai_bekerja = $attributes['mulai_bekerja'];
        $user->gaji = $attributes['gaji'];
        $user->save();

        return redirect($this->userManagementLink)->with('success', 'Data pegawai berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('role', 'user')->find($id);

        if ($user) {
            $user->delete(); // Soft delete data
            return redirect()->back()->with('success', 'Data pegawai berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', $this->notFoundMessage);
        }
    }
}