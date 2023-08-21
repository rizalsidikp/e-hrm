<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $dataAbsensi = "Data Absensi";
    protected $absenceManagementLink = "/absence-management";
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
        return view('pages.absence-management.create', compact('breadcrumbs'));
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