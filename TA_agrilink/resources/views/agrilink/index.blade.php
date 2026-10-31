@extends('layouts.agrilink')

@section('title', 'Katalog & Input Hasil Tani')

@section('content')
    @if($errors->any())
        <div class="alert-agri err">
            <strong>Data belum bisa disimpan:</strong>
            <ul style="margin:6px 0 0 18px; padding:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @guest
        <div style="background: rgba(30, 50, 30, 0.9); border: 1px solid #2e7d32; border-radius: 8px; padding: 16px; margin-bottom: 30px;">
            Ingin menambahkan komoditas? <a href="{{ route('login') }}" style="color:#81c784;">Login</a>
            atau <a href="{{ route('register') }}" style="color:#81c784;">Register</a> terlebih dahulu.
        </div>
    @endguest

    @auth
    {{-- Form Input Barang Baru (hanya untuk pengguna yang sudah login) --}}
    <div style="background: rgba(30, 50, 30, 0.9); border: 1px solid #2e7d32; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <h3 style="color: #81c784; margin-top: 0;">+ Tambah Komoditas Hasil Tani</h3>
        <form action="{{ route('agrilink.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:bold; color:white;">Nama Produk:</label>
                    <input type="text" name="nama_produk" required placeholder="Contoh: Kentang Granola Lembang" style="width:100%; padding:8px; border-radius:4px; border:1px solid #2e7d32; background:#0f200f; color:white; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:bold; color:white;">Lokasi / Petani:</label>
                    <input type="text" name="lokasi_petani" required placeholder="Contoh: Pak Herman (Kec. Jatibarang)" style="width:100%; padding:8px; border-radius:4px; border:1px solid #2e7d32; background:#0f200f; color:white; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:bold; color:white;">Harga per kg (Rp):</label>
                    <input type="number" name="harga" required placeholder="Contoh: 12000" style="width:100%; padding:8px; border-radius:4px; border:1px solid #2e7d32; background:#0f200f; color:white; box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:bold; color:white;">Stok (kg):</label>
                    <input type="number" name="stok" required placeholder="Contoh: 80" style="width:100%; padding:8px; border-radius:4px; border:1px solid #2e7d32; background:#0f200f; color:white; box-sizing:border-box;">
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:bold; color:white;">Kategori:</label>
                <select name="kategori_id" required style="width:100%; padding:8px; border-radius:4px; border:1px solid #2e7d32; background:#0f200f; color:white; box-sizing:border-box;">
                    <option value="">-- Pilih Kategori Produk --</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" style="background-color: #2e7d32; color: white; border: none; padding: 10px 20px; border-radius: 4px; font-weight: bold; cursor: pointer;">
                Simpan Produk Ke Katalog
            </button>
        </form>
    </div>
    @endauth

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Katalog Komoditas Hasil Tani Direct-from-Farmer</h2>
        @auth
        <a href="{{ route('agrilink.petani') }}" class="btn btn-outline-light btn-sm" style="background: #1b5e20; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;">Daftar Petani</a>
        @endauth
    </div>

    <div class="grid-produk" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        @forelse($produkList as $produk)
            @include('agrilink.partials.produk-card', ['produk' => $produk])
        @empty
            <p>Saat ini belum ada produk hasil tani yang tersedia.</p>
        @endforelse
    </div>
@endsection
