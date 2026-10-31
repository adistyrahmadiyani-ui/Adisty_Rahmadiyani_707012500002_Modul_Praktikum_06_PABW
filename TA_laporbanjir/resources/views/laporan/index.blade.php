@extends('layouts.app')

@section('title', 'Daftar Laporan Banjir')

@section('content')
    <h2 style="color: #ffffff; text-align: center; margin-bottom: 20px;">Daftar Laporan Kejadian Banjir</h2>

    @forelse($laporanList as $laporan)
        @include('partials.laporan-card', ['laporan' => $laporan])
    @empty
        <div class="card">
            <p>Belum ada laporan kejadian banjir yang terdaftar.</p>
        </div>
    @endforelse
@endsection