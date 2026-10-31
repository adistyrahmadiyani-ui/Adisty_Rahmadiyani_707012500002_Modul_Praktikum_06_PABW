@extends('layouts.app')

@section('title', 'Register Petugas')

@section('content')
    <div class="card">
        <h2>Registrasi Akun Petugas</h2>

        <form action="{{ route('register.store') }}" method="POST" novalidate>
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                       placeholder="Masukkan nama lengkap" autofocus>
                @error('name') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                       placeholder="nama@bpbd.go.id">
                @error('email') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"
                       class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                       placeholder="Minimal 8 karakter">
                @error('password') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       placeholder="Ulangi password">
            </div>

            <button type="submit" class="btn">Daftar</button>
        </form>

        <p style="margin-top:18px;">Sudah punya akun?
            <a class="link" href="{{ route('login') }}">Login di sini</a>.</p>
    </div>
@endsection
