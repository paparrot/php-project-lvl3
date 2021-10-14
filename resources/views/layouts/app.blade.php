<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <title>Анализатор страниц - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="min-vh-100 d-flex flex-column">
    <header class="flex-shrink-0">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <a class="navbar-brand" href="{{route('urls.create')}}">Анализатор страниц</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('urls.create') ? 'active' : ''}}" href="{{route('urls.create')}}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{request()->routeIs('urls.index') ? 'active' : ''}}" href="{{route('urls.index')}}">Сайты</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main class="flex-grow-1">
        @yield('content')
    </main>
    <footer class="border-top py-3 mt-5 flex-shrink-0">
        <div class="container-lg">
            <div class="text-center">
                <a href="https://paparrot.vercel.app/" target="_blank">Paparrot</a>
            </div>
        </div>
    </footer>
</body>
</html>
