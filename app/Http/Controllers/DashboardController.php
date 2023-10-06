<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $notFoundMessage = "Data pegawai tidak ditemukan.";
    protected $requiredWithMax50 = "required|max:50";
    protected $requiredWithDate = "required|date";
    public function index()
    {
        $breadcrumbs = [
            [
                "name" => "Dashboard",
            ]
        ];
        $user = $user = User::find(Auth::user()->id);
        return view('pages.dashboard.index', compact('user', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = $user = User::find(Auth::user()->id);
        if (!$user) {
            return redirect('dashboard')->with('error', $this->notFoundMessage);
        }
        $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required|email|max:50|unique:users,email,' . $id,
            'jenis_kelamin' => 'required|in:l,p',
            'tempat_lahir' => $this->requiredWithMax50,
            'tanggal_lahir' => $this->requiredWithDate,
            'alamat' => 'max:255',
            'no_hp' => 'max:20',
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
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tempat_lahir = $request->tempat_lahir;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->no_hp;
        if ($request->hasFile('photo')) {
            $folderPath = public_path('images/photo');

            // Cek apakah folder sudah ada, jika tidak, buat folder
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            $photo = $request->file('photo');
            $photoName = 'photo_' . $user->id . '.' . $photo->getClientOriginalExtension();

            // Pindahkan gambar photo baru ke direktori yang diinginkan
            $photo->move($folderPath, $photoName);

            // Update nama file photo di database atau sesuai dengan kebutuhan Anda
            $user->photo = 'images/photo/' . $photoName;
        }
        $user->save();

        return redirect('dashboard')->with('success', 'Informasi data diri berhasil diperbarui');
    }
}