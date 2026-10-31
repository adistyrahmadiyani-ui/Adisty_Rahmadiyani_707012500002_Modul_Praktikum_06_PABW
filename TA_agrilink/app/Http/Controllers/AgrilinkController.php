<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class AgrilinkController extends Controller
{
    // Menampilkan halaman katalog & form input
    public function index()
    {
        $produkList = Produk::with('kategori')->orderBy('created_at', 'desc')->get();
        $kategoriList = KategoriProduk::all();
        
        return view('agrilink.index', compact('produkList', 'kategoriList'));
    }

    // Menyimpan produk baru dari form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id'   => 'required|exists:kategori_produk,id',
            'nama_produk'   => 'required|string|max:255',
            'harga'         => 'required|numeric|min:0',
            'stok'          => 'required|integer|min:0',
            'lokasi_petani' => 'required|string|max:255',
        ]);

        Produk::create($validated);

        return redirect()->route('agrilink.index')->with('sukses', 'Komoditas hasil tani berhasil ditambahkan ke katalog!');
    }

    // Halaman daftar petani
 public function petani()
{
    // Mengambil data produk dikelompokkan berdasarkan lokasi petani
    $petaniList = Produk::select('lokasi_petani')->distinct()->get();
    
    return view('agrilink.petani', compact('petaniList'));
}
}