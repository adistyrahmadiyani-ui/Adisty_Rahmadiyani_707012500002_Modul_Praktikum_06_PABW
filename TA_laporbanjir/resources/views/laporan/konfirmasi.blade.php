@extends('layouts.app')

@section('title', 'Konfirmasi Laporan')

@section('content')
    <x-alert type="sukses" message="Laporan banjir berhasil dikirim dan dicatat oleh sistem BPBD & BMKG!" />

    <div class="card">
        <h2>Detail Laporan Anda:</h2>
        <p><strong>Nama Pelapor:</strong> {{ $laporan->nama_pelapor }}</p>
        <p><strong>Lokasi Kejadian:</strong> {{ $laporan->lokasi }}</p>
        <p><strong>Tinggi Genangan Air:</strong> {{ $laporan->tinggi_genangan }} cm</p>
        <p><strong>Tanggal Kejadian:</strong> {{ \Carbon\Carbon::parse($laporan->tanggal_kejadian)->format('d-m-Y') }}</p>
        <br>
        <a href="{{ route('laporan.create') }}" class="btn" style="text-decoration:none;">Kirim Laporan Lain</a>
        @auth
            <a href="{{ route('laporan.index') }}" class="btn" style="text-decoration:none;">Lihat Semua Daftar Laporan</a>
        @endauth
    </div>
@endsection
