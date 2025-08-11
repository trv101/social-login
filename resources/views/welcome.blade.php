<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Social-login') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- your inline Tailwind fallback stays here --}}
        <style>/* (keep your existing big inline Tailwind fallback CSS) */</style>
    @endif
</head>
<body class="relative min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]">

    {{-- ====== Wallpaper layer (uses your logo) ====== --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
    

        {{-- Soft gradient overlay for readability --}}
        <div class="absolute inset-0 bg-gradient-to-b from-white/70 via-white/40 to-white/80
                    dark:from-black/60 dark:via-black/40 dark:to-black/70">
        </div>
    </div>

    {{-- ====== Header ====== --}}
    <header class="relative z-10 w-full px-6 pt-6 flex items-center justify-end">
        @if (Route::has('login'))
            <nav class="flex items-center gap-3 text-sm">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="inline-flex items-center gap-2 px-4 py-1.5 rounded-md border border-[#19140035] dark:border-[#3E3E3A]
                              hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition">
                        <span>Dashboard</span>
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M7.293 14.707a1 1 0 010-1.414L9.586 11H4a1 1 0 110-2h5.586L7.293 6.707a1 1 0 111.414-1.414l4.999 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"/></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex px-4 py-1.5 rounded-md border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] transition">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="inline-flex px-4 py-1.5 rounded-md border border-[#19140035] dark:border-[#3E3E3A]
                                  hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    {{-- ====== Hero Card ====== --}}
    <main class="relative z-10 px-6 py-10 lg:py-16  flex items-center justify-center">
        <section class="w-full max-w-xl">
            <div class="mt-8 rounded-2xl border border-[#e3e3e0] dark:border-[#3E3E3A]
                        bg-white/75 dark:bg-[#161615]/70 backdrop-blur-md
                        shadow-[0_10px_30px_rgba(0,0,0,0.08)] p-8 lg:p-10">
                <div class="flex items-center gap-4 mb-6">
                    <img src="{{ asset('images/social-logo.png') }}" alt="{{ config('app.name') }} logo"
                         class="h-10 w-auto rounded-md">
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-semibold text-gray-900 dark:text-[#EDEDEC]">
                            {{ config('app.name', 'Social-login') }}
                        </h1>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            Sign in to sync your Calendar, Email, and Tasks.
                        </p>
                    </div>
                </div>

                {{--  --}}

                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="inline-flex items-center gap-2 mt-2 px-4 py-2.5 rounded-lg
                              bg-[#1b1b18] text-white hover:opacity-90
                              dark:bg-white dark:text-black transition">
                        Go to Dashboard
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M7.293 14.707a1 1 0 010-1.414L9.586 11H4a1 1 0 110-2h5.586L7.293 6.707a1 1 0 111.414-1.414l4.999 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"/></svg>
                    </a>
                @endauth
            </div>

            {{-- tiny footer --}}
            <p class="mt-6 text-center text-xs text-[#706f6c] dark:text-[#A1A09A]">
                {{ config('app.name', 'Social-login') }} securely connects to Google to read your calendar, email, and tasks.
            </p>
        </section>
    </main>
</body>
</html>
