<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Agrilink ID</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; line-height: 1.6;
            background: linear-gradient(rgba(20, 35, 20, 0.88), rgba(20, 35, 20, 0.88)), 
                        url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1920&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover; color: #e8f5e9; min-height: 100vh; display: flex; flex-direction: column;
        }
        header { background-color: rgba(27, 94, 32, 0.95); color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #81c784; }
        header h1 { margin: 0; font-size: 22px; }
        nav a { color: white; text-decoration: none; margin-left: 15px; font-weight: 600; padding: 6px 12px; border-radius: 4px; }
        nav a:hover { background-color: #2e7d32; }
        main { max-width: 1000px; width: 90%; margin: 30px auto; flex: 1; }
        .grid-produk { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; margin-top: 20px; }
        .card-produk { background: rgba(30, 50, 30, 0.9); border: 1px solid #2e7d32; border-radius: 8px; padding: 20px; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; color: white; }
        .bg-stok-ada { background-color: #2e7d32; }
        .bg-stok-habis { background-color: #c62828; }
        nav form { display: inline; }
        nav .nav-btn { background: none; border: none; cursor: pointer; font: inherit; color: white; margin-left: 15px; font-weight: 600; padding: 6px 12px; border-radius: 4px; }
        nav .nav-btn:hover { background-color: #c62828; }
        .alert-agri { padding: 12px; border-radius: 6px; margin-bottom: 16px; color: white; }
        .alert-agri.ok { background: #2e7d32; }
        .alert-agri.err { background: #c62828; }
        .card { background: rgba(30, 50, 30, 0.9); border: 1px solid #2e7d32; border-radius: 8px; padding: 25px; max-width: 520px; margin: 0 auto; }
        .card h2 { margin-top: 0; color: #81c784; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 600; }
        .form-group input { width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #2e7d32; background: #0f200f; color: white; box-sizing: border-box; }
        .form-group input.is-invalid { border-color: #ef5350; }
        .error-text { color: #ff8a80; font-size: 13px; margin-top: 4px; display: block; }
        .checkbox { display: flex; align-items: center; gap: 8px; margin-bottom: 18px; }
        .btn { background: #2e7d32; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn:hover { background: #388e3c; }
        .link { color: #81c784; }
        table.info { width: 100%; border-collapse: collapse; }
        table.info th, table.info td { text-align: left; padding: 10px 8px; border-bottom: 1px solid #2e7d32; }
        table.info th { width: 35%; color: #a5d6a7; }
        .user-info { color: #c8e6c9; font-size: 14px; }
        footer { background-color: rgba(27, 94, 32, 0.95); color: #a5d6a7; text-align: center; padding: 15px; margin-top: 40px; font-size: 14px; }
    </style>
</head>
<body>
    <header>
        <h1>Agrilink ID</h1>
        <nav>
            <a href="{{ route('agrilink.index') }}">Katalog Produk</a>
            @auth
                <a href="{{ route('agrilink.petani') }}">Daftar Petani</a>
                <a href="{{ route('profil') }}">Profil</a>
                <span class="user-info">({{ Auth::user()->name }})</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-btn">Logout</button>
                </form>
            @endauth
            @guest
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endguest
        </nav>
    </header>

    <main>
        @if (session('sukses'))
            <x-alert type="sukses" :message="session('sukses')" />
        @endif
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2026 Agrilink ID - Menghubungkan Petani Langsung ke Konsumen.</p>
    </footer>
</body>
</html>