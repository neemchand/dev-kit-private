<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
      darkMode: localStorage.getItem('darkMode')
      || localStorage.setItem('darkMode', 'system')}"
    x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
    x-bind:class="{'dark': darkMode === 'dark' || (darkMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)}"
    class="h-full bg-gray-100 dark dark:bg-gray-900">
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

<!-- Tailwind component URL -->
<!-- https://tailwindui.com/components/application-ui/application-shells/sidebar#component-5548358cb34897c6b28551f2ad885eec -->

<body class="h-full antialiased bg-gray-100 dark:bg-gray-900">

<div x-data="{ open: false }" class="dark:bg-gray-900">
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <div class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
        <div
            x-show="open"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/80"></div>

        <div x-show="open" class="fixed inset-0 flex">
            <div
                x-show="open"
                x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="relative mr-16 flex w-full max-w-xs flex-1">
                <div
                    x-show="open"
                    x-transition:enter="ease-in-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in-out duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" class="-m-2.5 p-2.5" @click="open = !open">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4 ring-1 ring-white/10">
                    <div class="flex h-16 shrink-0 items-center">
                        <x-glyph-logo class="h-8 w-auto" alt="{{ config('app.name', 'Laravel') }}"></x-glyph-logo>
                    </div>
                    @include('layouts.nav')

                </div>
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4">
            <div class="flex h-16 shrink-0 items-center">
                <x-glyph-logo class="h-16 w-auto" alt="{{ config('app.name', 'Laravel') }}"></x-glyph-logo>
            </div>
            @include('layouts.nav')
        </div>
    </div>

    <div class="lg:pl-72">
        <div
            class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white dark:bg-gray-900 dark:border-gray-800 px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
            <button @click="open = !open" type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
                <span class="sr-only">Open sidebar</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

            <!-- Separator -->
            <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"></div>

            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                <div class="relative flex flex-1" >
                    @if (isset($header))
                        <div class="flex items-center gap-x-4 lg:gap-x-6">
                            <div class="pt-2">
                                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{{ $header }}</h2>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex items-center gap-x-4 lg:gap-x-6">
{{--                    <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500" disabled="disabled">--}}
{{--                        <span class="sr-only">View notifications</span>--}}
{{--                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"--}}
{{--                             aria-hidden="true">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                  d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>--}}
{{--                        </svg>--}}
{{--                    </button>--}}

                    <!-- Separator -->
                    <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10" aria-hidden="true"></div>

                    <!-- Profile dropdown -->
                    <div x-data="{ isOpen: false }" class="relative">
                        <button type="button" class="-m-1.5 flex items-center p-1.5 text-gray-900 dark:text-gray-200" id="user-menu-button"
                                aria-expanded="false" aria-haspopup="true" @click="isOpen = !isOpen">
                            <span class="sr-only">Open user menu</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span class="hidden lg:flex lg:items-center">
                                <span class="ml-4 text-sm font-semibold leading-6 "
                                      aria-hidden="true">{{ Str::limit(Auth::user()->first_name, 40) }} </span>
                                <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </button>

                        <div
                            x-show="isOpen"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white dark:bg-gray-700 py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                        >
                            <!-- Active: "bg-gray-50", Not Active: "" -->
                                <x-dropdown-link :href="route('admin.profile.edit')" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                    {{ __('misc.profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('admin.logout')" role="menuitem" tabindex="-1"
                                                     id="user-menu-item-1" onclick="event.preventDefault();
                                                     this.closest('form').submit();"
                                    >
                                        {{ __('auth.log_out') }}
                                    </x-dropdown-link>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="py-5">
            <div class="px-4 sm:px-6 lg:px-8 dark:bg-gray-900">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

<div x-data="{}" aria-live="assertive" class="z-50 pointer-events-none fixed inset-0 flex px-4 py-6 items-end sm:p-6">
    <div class="flex w-full flex-col space-y-4 items-start">
        @if($notification = session('notification'))
{{--            <x-slot name="notification">--}}
                <x-notification-simple :type="$notification->type" :title="$notification->title"
                                       :description="$notification->description"/>
{{--            </x-slot>--}}
        @endif
{{--        @if (isset($notification))--}}
{{--            {{ $notification }}--}}
{{--        @endif--}}
    </div>
</div>

</body>
</html>
