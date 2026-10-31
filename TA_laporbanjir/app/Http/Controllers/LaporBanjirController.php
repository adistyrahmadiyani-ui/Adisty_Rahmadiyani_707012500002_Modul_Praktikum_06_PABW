<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporBanjirController extends Controller
{
    /**
     * Daftar semua laporan (TERPROTEKSI: hanya petugas yang login).
     */
    public function index()
    {
        $laporanList = Laporan::orderBy('created_at', 'desc')->get();

        return view('laporan.index', compact('laporanList'));
    }

    /**
     * Form pelaporan (PUBLIK: warga tidak perlu login).
     */
    public function create()
    {
        return view('laporan.create');
    }

    /**
     * Menyimpan laporan warga ke database (PUBLIK).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor'     => 'required|string|max:255',
            'lokasi'           => 'required|string|max:255',
            'tinggi_genangan'  => 'required|numeric|min:1',
            'tanggal_kejadian' => 'required|date',
        ], [
            'nama_pelapor.required'     => 'Nama pelapor wajib diisi.',
            'lokasi.required'           => 'Lokasi kejadian wajib diisi.',
            'tinggi_genangan.required'  => 'Tinggi genangan wajib diisi.',
            'tinggi_genangan.numeric'   => 'Tinggi genangan harus berupa angka.',
            'tinggi_genangan.min'       => 'Tinggi genangan minimal 1 cm.',
            'tanggal_kejadian.required' => 'Tanggal kejadian wajib diisi.',
            'tanggal_kejadian.date'     => 'Format tanggal kejadian tidak valid.',
        ]);

        $laporan = Laporan::create($validated);

        return view('laporan.konfirmasi', compact('laporan'));
    }
}
