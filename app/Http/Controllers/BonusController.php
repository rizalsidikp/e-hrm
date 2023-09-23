<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\User;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    protected $dataBonus = "Data Bonus";
    protected $bonusManagementLink = "/bonus-management";
    protected $notFoundMessage = "Data bonus tidak ditemukan.";
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
                "name" => $this->dataBonus,
            ]
        ];
        $bonuses = Bonus::orderBy('id', 'desc')->get();
        return view('pages.bonus-management.index', compact('bonuses', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            [
                "name" => $this->dataBonus,

                "link" => $this->bonusManagementLink,
            ],
            [
                "name" => "Bonus Pegawai Baru",
            ]
        ];
        $users = User::where('id', '!=', '1')->get();
        return view('pages.bonus-management.create', compact('breadcrumbs', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bonus' => 'required|numeric',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);
        $periode = $request->tahun . '-' . str_pad($request->bulan, 2, '0', STR_PAD_LEFT).'-15';
        $data = [
            'user_id' => $request->user_id,
            'bonus' => $request->bonus,
            'periode' => $periode,
            'deskripsi' => $request->deskripsi
        ];
        $bonus = new Bonus($data);
        $bonus->save();
        return redirect($this->bonusManagementLink)->with('success', 'Bonus pegawai berhasil ditambah'); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $breadcrumbs = [
            [
                "name" => $this->dataBonus,
                "link" => $this->bonusManagementLink
            ],
            [
                "name" => "Ubah Informasi Bonus Pegawai",
            ]
        ];
        $bonus = Bonus::find($id);
        $users = User::where('id', '!=', '1')->get();
        if (!$bonus) {
            return redirect($this->bonusManagementLink)->with('error', $this->notFoundMessage);
        }

        return view('pages.bonus-management.edit', compact('bonus', 'users', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bonus = Bonus::find($id);
        if (!$bonus) {
            return redirect($this->bonusManagementLink)->with('error', $this->notFoundMessage);
        }
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bonus' => 'required|numeric',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);
        $periode = $request->tahun . '-' . str_pad($request->bulan, 2, '0', STR_PAD_LEFT).'-15';
        $bonus->user_id = $request->user_id;
        $bonus->bonus = $request->bonus;
        $bonus->periode = $periode;
        $bonus->deskripsi = $request->deskripsi;
        $bonus->save();

        return redirect($this->bonusManagementLink)->with('success', 'Bonus pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bonus = Bonus::find($id);
        if ($bonus) {
            $bonus->delete();
            return redirect()->back()->with('success', 'Bonus pegawai berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', $this->notFoundMessage);
        }
    }
}