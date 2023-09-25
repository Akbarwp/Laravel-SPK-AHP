<!DOCTYPE html>
<html lang="en" data-theme="light" :class="{ 'theme-dark': dark }" x-data="data()" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | {{ $judul }}</title>

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/logo.jpg') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/logo.jpg') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('dashboard.layouts.link')
    @yield('css')

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-workSans scrollbar-thin scrollbar-thumb-purple-600 scrollbar-track-purple-600/60 scrollbar-thumb-rounded-full hover:scrollbar-thumb-purple-600/80 transition-all">
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        @include('dashboard.layouts.sidebar')

        <div class="flex flex-col flex-1 w-full">
            @include('dashboard.layouts.navbar')
            <main class="h-full overflow-y-auto">
                @yield('container')
                @include('dashboard.layouts.footer')
            </main>
        </div>
    </div>

    @include('dashboard.layouts.script')
    @yield('js')
</body>
</html>
