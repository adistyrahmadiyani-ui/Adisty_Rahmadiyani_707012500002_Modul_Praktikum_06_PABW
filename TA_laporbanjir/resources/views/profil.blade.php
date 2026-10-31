@extends('layouts.app')

@section('title', 'Profil Petugas')

@section('content')
    <div class="card">
        <h2>Profil Petugas</h2>
        <table class="info">
            <tr>
                <th>Nama</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Akun dibuat pada</th>
                <td>{{ $user->created_at->timezone('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y, H:i') }} WIB</td>
            </tr>
        </table>
    </div>
@endsection
