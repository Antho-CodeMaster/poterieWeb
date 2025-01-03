<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="//unpkg.com/alpinejs" ></script>
    <script>
    window.csrfToken = "{{ csrf_token() }}";
    window.notificationHideRoute = "{{ route('notification.hide') }}";
    window.likeToggleUrl = "{{ route('like.toggle', ':idArticle') }}";
    window.addToCartUrl = "{{ route('addArticleToPanier')}}";
    </script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-ffffff flex flex-col">
        @include('layouts.navigation')

        @auth
           <!-- Modal du 2fa-->
            @include('components.2fa-modal')
            @if (Auth::user()->uses_2fa == 1 &&
                    (!session()->has('2fa:auth:passed') || session()->get('2fa:auth:passed') == false))
                <div x-data="$dispatch('open-2fa-modal')"></div>
            @endif

        @endauth

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="pt-[44px] grow">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        @include('layouts.footer')
    </div>
</body>

</html>
