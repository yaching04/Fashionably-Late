<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fashionably Late</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/layout.css') }}">
    @yield('css')
</head>

<body>

    <header class="header">
        <div class="header__inner">

            <!-- ロゴ（中央） -->
            <a href="{{ url('/') }}" class="logo">Fashionably Late</a>

            <!-- 認証リンク（右側強制） -->
            <div class="auth-links">
                @if (request()->routeIs('register'))
                    <a href="{{ route('login') }}" class="login-btn">Login</a>

                @elseif (request()->routeIs('login') || request()->routeIs('admin.login'))
                    <a href="{{ route('register') }}" class="login-btn">Register</a>

                @elseif (auth()->check())
                    <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="login-btn">Logout</button>
                    </form>
                @endif
            </div>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>

    @yield('js')

</body>
</html>
