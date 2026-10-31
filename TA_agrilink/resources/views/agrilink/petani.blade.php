@extends('layouts.agrilink')

@section('title', 'Daftar Mitra Petani')

@section('content')
    <a href="{{ route('agrilink.index') }}" class="btn btn-secondary mb-4" style="background: #388e3c; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px;">&larr; Kembali ke Katalog</a>
    
    <h2 class="mb-4 text-white">Daftar Mitra Petani Agrilink ID</h2>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        @forelse($petaniList as $petani)
            <div class="card shadow-sm" style="background: #112611; border: 1px solid #2e7d32; border-radius: 8px; padding: 15px; color: white;">
                <div class="card-body">
                    {{-- PERBAIKAN DI SINI: Menggunakan $petani->lokasi_petani --}}
                    <h5 class="card-title fw-bold" style="color: #a5d6a7;">📍 Lokasi: {{ $petani->lokasi_petani }}</h5>
                    <p class="card-text text-muted small mt-2">Mitra petani lokal aktif yang menyediakan hasil bumi berkualitas langsung dari ladang.</p>
                    <a href="{{ route('agrilink.index') }}" class="btn btn-outline-success btn-sm mt-2" style="color: #81c784; border-color: #2e7d32; text-decoration: none; padding: 4px 10px;">Lihat Produk Wilayah Ini</a>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">Belum ada data petani terdaftar.</div>
            </div>
        @endforelse
    </div>
@endsection