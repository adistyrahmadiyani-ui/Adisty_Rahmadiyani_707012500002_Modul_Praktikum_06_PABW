<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfilController extends Controller
{
    /**
     * Menampilkan profil petugas yang sedang login (via Auth::user()).
     */
    public function show(): View
    {
        $user = Auth::user();

        return view('profil', compact('user'));
    }
}
