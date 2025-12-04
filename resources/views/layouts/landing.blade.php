<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'VibeSense AI' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    {{-- NAVBAR --}}
    @include('components.navbar')

    {{-- PAGE CONTENT --}}
    <main class="pt-20">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('components.footer')

</body>

</html>
