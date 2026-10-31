<div class="card shadow-sm" style="background: #112611; border: 1px solid #2e7d32; border-radius: 8px; padding: 15px; color: white; margin-bottom: 15px;">
    <div class="card-body">
        
        {{-- Kategori (Aman dari JSON mentah) --}}
        <span class="badge bg-secondary mb-2" style="background: #388e3c; padding: 4px 8px; border-radius: 4px; font-size: 12px; display: inline-block;">
            {{ optional($produk->kategori)->nama_kategori ?? 'Tanpa Kategori' }}
        </span>
        
        {{-- Nama Produk --}}
        <h5 class="card-title fw-bold" style="color: #a5d6a7; margin-top: 8px; margin-bottom: 10px;">
            {{ $produk->nama_produk ?? $produk->nama ?? 'Produk Tanpa Nama' }}
        </h5>

        {{-- Harga Produk --}}
        <p class="text-warning fw-bold fs-5 mb-2">
            Rp {{ number_format($produk->harga ?? 0, 0, ',', '.') }} / kg
        </p>

        {{-- Status Stok --}}
        <p class="card-text text-light small mb-1">
            Status Stok: <span class="badge bg-success" style="background: #2e7d32; padding: 2px 6px; border-radius: 3px;">Tersedia ({{ $produk->stok ?? 0 }} kg)</span>
        </p>

        {{-- Petani / Lokasi --}}
        <p class="card-text small text-secondary mt-1">
            Petani: {{ $produk->lokasi_petani ?? $produk->petani ?? 'Tidak diketahui' }}
        </p>

    </div>
</div>