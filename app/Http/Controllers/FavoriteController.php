<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $favorite = Favorite::where('user_id', $request->user_id)->where('label', $request->label)->where('icon', $request->icon)->where('url', $request->url)->get();
        if ($favorite->count() == 0) {
            $data = [
                'user_id' => $request->user_id,
                'label' => $request->label,
                'icon' => $request->icon,
                'url' => $request->url
            ];
            $favorite = new Favorite($data);
            $favorite->save();
        }
        return redirect()->back()->with('success', 'Halaman berhasil ditambahkan ke favorit');; 
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $favorite = Favorite::where('user_id', $request->user_id)->where('label', $request->label)->where('icon', $request->icon)->where('url', $request->url)->get();
        if ($favorite) {
            $favorite->each->delete();
            return redirect()->back()->with('success', 'Halaman berhasil dihapus dari favorit');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus halaman dari favorit');
        }
    }
}
