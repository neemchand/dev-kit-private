<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
      darkMode: localStorage.getItem('darkMode')
      || localStorage.setItem('darkMode', 'system')}"
    x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
    x-bind:class="{'dark': darkMode === 'dark' || (darkMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)}"
    class="bg-white dark dark:bg-gray-900">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('images/favicon.png') }}">
        <link rel="apple-touch-icon-precomposed" href="{{ asset('images/apple-touch-icon-precomposed.png') }}">
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div>
                <a href="{{route('admin.login')}}" class="text-gray-700 dark:text-gray-400">
                    <x-main-logo class="w-48 h-20" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        <div x-data="{}" aria-live="assertive" class="z-50 pointer-events-none fixed inset-0 flex px-4 py-6 items-end sm:p-6">
            <div class="flex w-full flex-col space-y-4 items-start">
                @if($notification = session('notification'))
                    <x-notification-simple :type="$notification->type" :title="$notification->title"
                                           :description="$notification->description"/>
                @endif
            </div>
        </div>
    </body>
</html>
