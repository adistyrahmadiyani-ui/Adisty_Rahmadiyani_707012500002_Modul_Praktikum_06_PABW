@extends('layouts.app')

@section('title', 'Form Pelaporan Banjir')

@section('content')
    <div class="card">
        <h2>Form Lapor Kejadian Banjir</h2>
        <p>Warga dapat melapor tanpa login.</p>
        <form action="{{ route('laporan.store') }}" method="POST" novalidate>
            @csrf
            <div class="form-group">
                <label for="nama_pelapor">Nama Pelapor:</label>
                <input type="text" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor') }}"
                       class="{{ $errors->has('nama_pelapor') ? 'is-invalid' : '' }}"
                       placeholder="Masukkan nama lengkap">
                @error('nama_pelapor') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi Kejadian:</label>
                <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
                       class="{{ $errors->has('lokasi') ? 'is-invalid' : '' }}"
                       placeholder="Masukkan nama kecamatan/desa">
                @error('lokasi') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="tinggi_genangan">Tinggi Genangan Air (cm):</label>
                <input type="number" id="tinggi_genangan" name="tinggi_genangan" value="{{ old('tinggi_genangan') }}"
                       class="{{ $errors->has('tinggi_genangan') ? 'is-invalid' : '' }}"
                       placeholder="Contoh: 45">
                @error('tinggi_genangan') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_kejadian">Tanggal Kejadian:</label>
                <input type="date" id="tanggal_kejadian" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}"
                       class="{{ $errors->has('tanggal_kejadian') ? 'is-invalid' : '' }}">
                @error('tanggal_kejadian') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn">Kirim Laporan</button>
        </form>
    </div>
@endsection
