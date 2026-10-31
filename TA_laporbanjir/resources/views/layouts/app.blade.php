<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | LaporBanjir BPBD & BMKG</title>
    <style>
        /* CSS Tema BMKG & Background Image */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 0;
            line-height: 1.6;
            /* Foto background bencana/cuaca dengan overlay gelap transparan */
            background: linear-gradient(rgba(10, 25, 47, 0.85), rgba(10, 25, 47, 0.85)), 
                        url('https://images.unsplash.com/photo-1547683905-f686c993aae5?q=80&w=1920&auto=format&fit=crop') no-repeat center center fixed;
            background-size: cover;
            color: #e6f1ff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header { 
            background: rgba(15, 32, 67, 0.95); 
            color: #ffffff; 
            padding: 15px 20px; 
            text-align: center; 
            border-bottom: 3px solid #ffcc00; /* Warna emas BMKG */
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        header h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
            color: #ffffff;
        }

        nav { 
            margin-top: 12px; 
        }

        nav a { 
            color: #e6f1ff; 
            margin: 0 12px; 
            text-decoration: none; 
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        nav a:hover { 
            background-color: #ffcc00; 
            color: #0a192f; 
        }

        main { 
            max-width: 800px;
            width: 90%;
            margin: 30px auto; 
            flex: 1;
        }

        .card { 
            background: rgba(23, 42, 69, 0.9); 
            border: 1px solid #233554; 
            padding: 25px; 
            margin-bottom: 20px; 
            border-radius: 10px; 
            box-shadow: 0 8px 16px rgba(0,0,0,0.4);
            backdrop-filter: blur(5px);
        }

        .card h2, .card h3 {
            margin-top: 0;
            color: #64ffda;
        }

        .form-group { 
            margin-bottom: 18px; 
        }

        .form-group label { 
            display: block; 
            margin-bottom: 6px; 
            font-weight: 600; 
            color: #ccd6f6;
        }

        .form-group input { 
            width: 100%; 
            padding: 10px; 
            border-radius: 5px;
            border: 1px solid #233554;
            background-color: #0a192f;
            color: #ffffff;
            box-sizing: border-box; 
        }

        .form-group input:focus {
            outline: none;
            border-color: #64ffda;
        }

        .btn { 
            background: #00bcd4; /* Biru Laut BMKG */
            color: #0a192f; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-weight: bold;
            transition: background 0.3s;
        }

        .btn:hover { 
            background: #64ffda; 
        }

        .badge { 
            display: inline-block; 
            padding: 5px 10px; 
            color: white; 
            border-radius: 4px; 
            font-weight: bold; 
        }

        .bg-waspada { background-color: #ffc107; color: #000; }
        .bg-siaga { background-color: #fd7e14; }
        .bg-awas { background-color: #dc3545; }

        .form-group input.is-invalid { border-color: #dc3545; }
        .error-text { color: #ff8a95; font-size: 13px; margin-top: 4px; display: block; }
        .form-group .hint { color: #8892b0; font-size: 13px; }
        .checkbox { display: flex; align-items: center; gap: 8px; margin-bottom: 18px; }
        .checkbox input { width: auto; }
        .link { color: #64ffda; }

        table.info { width: 100%; border-collapse: collapse; }
        table.info th, table.info td { text-align: left; padding: 10px 8px; border-bottom: 1px solid #233554; vertical-align: top; }
        table.info th { width: 35%; color: #ccd6f6; }

        /* Tombol logout dibuat tampil seperti link menu */
        nav form { display: inline; }
        nav .nav-btn {
            background: none; border: none; cursor: pointer; font: inherit;
            color: #e6f1ff; margin: 0 12px; font-weight: 600; padding: 6px 12px; border-radius: 4px;
            transition: all 0.3s ease;
        }
        nav .nav-btn:hover { background-color: #dc3545; color: #fff; }
        .user-info { color: #ffcc00; font-size: 14px; margin-top: 8px; }

        footer { 
            background: rgba(15, 32, 67, 0.95); 
            color: #8892b0; 
            padding: 15px; 
            text-align: center; 
            border-top: 1px solid #233554;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <h1>LaporBanjir - BPBD & BMKG Kabupaten Bandung</h1>
        <nav>
            {{-- Menu untuk semua pengunjung (warga) --}}
            <a href="{{ route('laporan.create') }}">Buat Laporan</a>

            @auth
                {{-- Menu khusus petugas yang sudah login --}}
                <a href="{{ route('laporan.index') }}">Daftar Laporan</a>
                <a href="{{ route('profil') }}">Profil Petugas</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-btn">Logout</button>
                </form>
            @endauth

            @guest
                {{-- Menu untuk pengunjung yang belum login --}}
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endguest
        </nav>
        @auth
            <div class="user-info">Masuk sebagai: {{ Auth::user()->name }}</div>
        @endauth
    </header>

    <main>
        @if (session('sukses'))
            <x-alert type="sukses" :message="session('sukses')" />
        @endif
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2026 BPBD & BMKG Kabupaten Bandung. Sistem Informasi Pelaporan Banjir.</p>
    </footer>
</body>
</html>