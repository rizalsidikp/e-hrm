<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    protected $dataPengumuman = "Data Pengumuman";
    protected $announcementManagementLink = "/announcement-management";
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
        $announcements = Announcement::orderBy('id', 'desc')->get();
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

                "link" => $this->announcementManagementLink
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
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            // Validasi deskripsi Quill
            'link' => 'nullable|url' // Validasi link
        ]);

        $announcement = new Announcement();
        $announcement->user_id = auth()->user()->id;
        $announcement->judul = $request->judul;
        $announcement->deskripsi = $request->deskripsi;
        $announcement->link = $request->link;
        $announcement->save();

        return redirect($this->announcementManagementLink)->with('success', 'Data pegawai berhasil ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $breadcrumbs = [
            [
                "name" => $this->dataPengumuman,
                "link" => $this->announcementManagementLink
            ],
            [
                "name" => "Ubah Informasi Pengumuman",
            ]
        ];
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return redirect($this->announcementManagementLink)->with('error', $this->notFoundMessage);
        }

        return view('pages.announcement-management.edit', compact('announcement', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return redirect($this->announcementManagementLink)->with('error', $this->notFoundMessage);
        }
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            // Validasi deskripsi Quill
            'link' => 'nullable|url' // Validasi link
        ]);
        $announcement->judul = $request->judul;
        $announcement->deskripsi = $request->deskripsi;
        $announcement->link = $request->link;
        $announcement->save();

        return redirect($this->announcementManagementLink)->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}