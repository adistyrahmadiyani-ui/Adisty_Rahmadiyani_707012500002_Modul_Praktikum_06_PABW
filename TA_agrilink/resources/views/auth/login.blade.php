@extends('layouts.agrilink')

@section('title', 'Login')

@section('content')
    <div class="card">
        <h2>Login Agrilink ID</h2>
        <p>Login diperlukan untuk menambah komoditas dan melihat daftar petani.</p>

        <form action="{{ route('login.authenticate') }}" method="POST" novalidate>
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                       placeholder="nama@email.com" autofocus>
                @error('email') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"
                       class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                       placeholder="Masukkan password">
                @error('password') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <label class="checkbox">
                <input type="checkbox" name="remember" value="1"> Ingat saya
            </label>

            <button type="submit" class="btn">Login</button>
        </form>

        <p style="margin-top:18px;">Belum punya akun?
            <a class="link" href="{{ route('register') }}">Daftar di sini</a>.</p>
    </div>
@endsection
