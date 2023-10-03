<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class AnnouncementController extends Controller
{
    protected $dataPengumuman = "Data Pengumuman";
    protected $announcementManagementLink = "/announcement-management";
    protected $notFoundMessage = "Data pengumuman tidak ditemukan.";
    protected $userMenu;
    protected $menuUrl;
    public function __construct()
    {
        $currentRoute = app('router')->getCurrentRoute();
        $routeName = $currentRoute->getName();
        $routeParts = explode('.', $routeName);
        $this->menuUrl = $routeParts[0];
        $this->middleware('checkRole:admin,superadmin')->except(['index']);
        $this->userMenu = $this->menuUrl === 'announcement';
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ($this->redirectToUserPage()) {
            return redirect('/announcement');
        }
        $breadcrumbs = [
            [
                "name" => $this->dataPengumuman,
            ]
        ];
        $announcements = [];
        if ($this->userMenu) {
            $announcements = Announcement::where('active', true)->orderBy('id', 'desc')->get();
        }else{
            $announcements = Announcement::orderBy('id', 'desc')->get();
        }
        return view('pages.announcement-management.index', compact('announcements', 'breadcrumbs'))->with('menuUrl', $this->menuUrl);
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
            'banner' => 'nullable',
            // Validasi deskripsi Quill
            'active' => 'in:on',
            'link' => 'nullable|url' // Validasi link
        ]);

        $isValidFile = false;
        if ($request->banner) {
            $newFilePath = $request->banner;
            $originalFilePath = 'images/announcement/temp-' . Str::afterLast($newFilePath, '/');
            if (file_exists(public_path($originalFilePath))) {
                $isValidFile = true;
                // Ubah nama file
                File::move(public_path($originalFilePath), public_path($newFilePath));

                // Hapus semua file dengan awalan "temp-"
                $tempFiles = File::glob(public_path('images/announcement/temp-*'));
                foreach ($tempFiles as $tempFile) {
                    File::delete($tempFile);
                }
            }

        }

        $data = [
            'user_id' => auth()->user()->id,
            'judul' => $request->judul,
            'banner' => $isValidFile ? $request->banner : null,
            'deskripsi' => $request->deskripsi,
            'link' => $request->link,
            'active' => !!$request->active
        ];

        $announcement = new Announcement($data);
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
            'banner' => 'nullable',
            'deskripsi' => 'required',
            // Validasi deskripsi Quill
            'link' => 'nullable|url', // Validasi link
            'active' => 'in:on',
        ]);
        $announcement->judul = $request->judul;
        $announcement->deskripsi = $request->deskripsi;
        $announcement->link = $request->link;
        $announcement->active = !!$request->active;
        if($announcement->banner !== $request->banner){
            if ($request->banner) {
                $newFilePath = $request->banner;
                $originalFilePath = 'images/announcement/temp-' . Str::afterLast($newFilePath, '/');
                if (file_exists(public_path($originalFilePath))) {
                    // Ubah nama file
                    File::move(public_path($originalFilePath), public_path($newFilePath));
                    // hapus data sebelumnya
                    File::delete($announcement->banner);
                    // Hapus semua file dengan awalan "temp-"
                    $tempFiles = File::glob(public_path('images/announcement/temp-*'));
                    foreach ($tempFiles as $tempFile) {
                        File::delete($tempFile);
                    }
                    $announcement->banner = $request->banner;
                }

            }
        }
        $announcement->save();

        return redirect($this->announcementManagementLink)->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $announcement = Announcement::find($id);
        if ($announcement) {
            File::delete($announcement->banner);
            $announcement->delete();
            return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', $this->notFoundMessage);
        }
    }

    public function uploadBanner(Request $request)
    {
        if ($request->hasFile('banner')) {
            $banner = null;
            if ($request->hasFile('banner')) {
                $file = $request->file('banner');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $fileNameWithTemp = "temp-" . $fileName;
                $folderPath = public_path('images/announcement');

                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0755, true);
                }

                $filePath = $folderPath . '/' . $fileNameWithTemp;
                if (move_uploaded_file($file->getPathname(), $filePath)) {
                    $banner = 'images/announcement/' . $fileName;
                    $response = ['banner' => $banner];
                    return response()->json($response);
                }
            }
        }
        return response()->json(['message' => 'Gagal mengunggah berkas.'], 400);
    }
    protected function redirectToUserPage()
    {
        $role = Auth::user()->role;
        if (!$this->userMenu && ($role !== 'admin' && $role !== 'superadmin')) {
            return true;
        }
        return false;
    }
}