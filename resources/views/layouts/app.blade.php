<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'My App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 flex flex-col justify-between antialiased">
    {{-- Header --}}
    @include('partials.header')

    {{-- Main Content --}}
    <main class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')    
</body>
</html>
