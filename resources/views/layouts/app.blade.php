<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Spendly') | Spendly</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>

    @auth
        <x-navigation />
    @endauth

    <main class="@auth app-content @endauth">

        {{-- Flash notifications --}}
        @if (session('success'))
            <div class="container-fluid px-4 px-lg-5 pt-4">
                <x-alert type="success">
                    {{ session('success') }}
                </x-alert>
            </div>
        @endif

        @if (session('error'))
            <div class="container-fluid px-4 px-lg-5 pt-4">
                <x-alert type="error">
                    {{ session('error') }}
                </x-alert>
            </div>
        @endif

        @if (session('warning'))
            <div class="container-fluid px-4 px-lg-5 pt-4">
                <x-alert type="warning">
                    {{ session('warning') }}
                </x-alert>
            </div>
        @endif

        @if (session('info'))
            <div class="container-fluid px-4 px-lg-5 pt-4">
                <x-alert type="info">
                    {{ session('info') }}
                </x-alert>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
