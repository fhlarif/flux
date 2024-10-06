<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxStyles
    @stack('headsScripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('darkMode', () => ({
                dark: false,
                toggle() {
                    this.dark = !this.dark;
                    if (this.dark) {
                        document.documentElement.classList.add('dark');
                        localStorage.theme = 'dark'
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.theme = 'light'
                    }
                },
                init() {
                    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                        document.documentElement.classList.add('dark');
                        localStorage.theme = 'dark'
                        this.dark = true;
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.removeItem('theme')
                        this.dark = false;
                    }
                }
            }))
        })
    </script>
</head>
<body class="min-h-screen bg-gray-100 dark:bg-gray-900">
<flux:header container class="bg-gray-100 dark:bg-gray-900">
    <flux:spacer/>
    <flux:navbar class="mr-4" x-data="darkMode">
        <flux:tooltip content="Toggle dark mode">
            {{--            <flux:navbar.item x-on:click="toggle" icon="moon" href="#" label="Toggle dark mode"/>--}}
            <flux:button icon="moon" variant="subtle" x-on:click="toggle" x-show="dark===false"/>
            <flux:button icon="sun" variant="filled" x-on:click="toggle" x-show="dark===true"/>
        </flux:tooltip>
    </flux:navbar>
</flux:header>
<flux:main container
           class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 relative">
    <div>
        <a href="/" wire:navigate>
            <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
        </a>
    </div>
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</flux:main>
@fluxScripts
@stack('scripts')
</body>
</html>
