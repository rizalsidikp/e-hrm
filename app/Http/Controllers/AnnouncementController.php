<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    protected $dataPengumuman = "Data Pengumuman";
    protected $anouncementManagementLink = "/announcement-management";
    protected $notFoundMessage = "Data pengumuman tidak ditemukan.";
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
                "name" => $this->dataPengumuman,
            ]
        ];
        $announcements = Announcement::all();
        return view('pages.announcement-management.index', compact('announcements', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            [
                "name" => $this->dataPengumuman,

                "link" => $this->anouncementManagementLink
            ],
            [
                "name" => "Pengumuman Baru",
            ]
        ];
        return view('pages.announcement-management.create', compact('breadcrumbs'));
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