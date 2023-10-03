<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Training;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    protected $dataTraining;
    protected $trainingManagementLink;
    protected $notFoundMessage = "Data pelatihan tidak ditemukan.";
    protected $menuUrl;
    protected $userMenu;
    public function __construct()
    {
        $currentRoute = app('router')->getCurrentRoute();
        $routeName = $currentRoute->getName();
        $routeParts = explode('.', $routeName);
        $this->menuUrl = $routeParts[0];
        $this->middleware('checkRole:admin,superadmin')->except(['index']);
        $this->userMenu = $this->menuUrl === 'training';
        $this->dataTraining = $this->userMenu ? "Pelatihan Saya" : "Data Pelatihan";
        $this->trainingManagementLink = '/' . $this->menuUrl;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ($this->redirectToUserPage()) {
            return redirect('/training');
        }
        $breadcrumbs = [
            [
                "name" => $this->dataTraining,
            ]
        ];
        $trainigs = null;
        if ($this->userMenu) {
            $trainings = Training::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        }else{
            $trainings = Training::orderBy('id', 'desc')->get();
        }
        return view('pages.training-management.index', compact('trainings', 'breadcrumbs'))->with('menuUrl', $this->menuUrl);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            [
                "name" => $this->dataTraining,

                "link" => $this->trainingManagementLink,
            ],
            [
                "name" => "Pelatihan Baru",
            ]
        ];
        $users = User::where('id', '!=', '1')->get();
        return view('pages.training-management.create', compact('breadcrumbs', 'users'))->with('menuUrl', $this->menuUrl);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required_if:tipe_pelatihan,pegawai|nullable',
            // Pastikan user_id valid dan ada dalam tabel users
            'tipe_pelatihan' => 'required|in:pegawai,perusahaan',
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'file' => 'required',
        ]);

        $isValidFile = false;
        if ($request->file) {
            $newFilePath = $request->file;
            $originalFilePath = 'images/pelatihan/temp-' . Str::afterLast($newFilePath, '/');
            if (file_exists(public_path($originalFilePath))) {
                $isValidFile = true;
                // Ubah nama file
                File::move(public_path($originalFilePath), public_path($newFilePath));

                // Hapus semua file dengan awalan "temp-"
                $tempFiles = File::glob(public_path('images/pelatihan/temp-*'));
                foreach ($tempFiles as $tempFile) {
                    File::delete($tempFile);
                }
            }

        }

        $data = [
            'user_id' => $request->tipe_pelatihan === 'pegawai' ? $request->user_id : null,
            'tipe_pelatihan' => $request->tipe_pelatihan,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'file' => $isValidFile ? $request->file : null,
        ];

        $training = new Training($data);
        $training->save();
        return redirect($this->trainingManagementLink)->with('success', 'Pelatihan berhasil ditambah');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $breadcrumbs = [
            [
                "name" => $this->dataTraining,
                "link" => $this->trainingManagementLink
            ],
            [
                "name" => "Ubah Informasi Pelatihan",
            ]
        ];
        $training = Training::find($id);
        $users = User::where('id', '!=', '1')->get();
        if (!$training) {
            return redirect($this->trainingManagementLink)->with('error', $this->notFoundMessage);
        }

        return view('pages.training-management.edit', compact('training', 'users', 'breadcrumbs'))->with('menuUrl', $this->menuUrl);;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required_if:tipe_pelatihan,pegawai|nullable',
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'file' => 'required',
        ]);
        $training = Training::find($id);
        if (!$training) {
            return redirect($this->trainingManagementLink)->with('error', $this->notFoundMessage);
        }
        $training->user_id = $training->tipe_pelatihan === 'pegawai' ? $request->user_id : null;
        $training->nama = $request->nama;
        $training->deskripsi = $request->deskripsi;
        
        if($training->file !== $request->file){
            if ($request->file) {
                $newFilePath = $request->file;
                $originalFilePath = 'images/pelatihan/temp-' . Str::afterLast($newFilePath, '/');
                if (file_exists(public_path($originalFilePath))) {
                    // Ubah nama file
                    File::move(public_path($originalFilePath), public_path($newFilePath));
                    // hapus data sebelumnya
                    File::delete($training->file);
                    // Hapus semua file dengan awalan "temp-"
                    $tempFiles = File::glob(public_path('images/pelatihan/temp-*'));
                    foreach ($tempFiles as $tempFile) {
                        File::delete($tempFile);
                    }
                    $training->file = $request->file;
                }

            }
        }
        $training->save();
        return redirect($this->trainingManagementLink)->with('success', 'Pelatihan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $training = Training::find($id);
        if ($training) {
            File::delete($training->file);
            $training->delete();
            return redirect()->back()->with('success', 'Pelatihan berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', $this->notFoundMessage);
        }
    }

    protected function redirectToUserPage()
    {
        $role = Auth::user()->role;
        if (!$this->userMenu && ($role !== 'admin' && $role !== 'superadmin')) {
            return true;
        }
        return false;
    }

    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $fileNameWithTemp = "temp-" . $fileName;
                $folderPath = public_path('images/pelatihan');

                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0755, true);
                }

                $filePath = $folderPath . '/' . $fileNameWithTemp;
                if (move_uploaded_file($file->getPathname(), $filePath)) {
                    $file = 'images/pelatihan/' . $fileName;
                    $response = ['file' => $file];
                    return response()->json($response);
                }
            }
        }
        return response()->json(['message' => 'Gagal mengunggah berkas.'], 400);
    }

}
