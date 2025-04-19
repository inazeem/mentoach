<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Mentoach - Your Professional Mentoring Platform. Connect with experienced mentors, schedule appointments, and accelerate your career growth.">
        <meta name="keywords" content="mentoring, professional development, career growth, coaching, appointments">
        <meta name="author" content="Mentoach">
        <meta name="robots" content="index, follow">
        <meta property="og:title" content="{{ config('app.name', 'Mentoach') }}">
        <meta property="og:description" content="Connect with experienced mentors and accelerate your career growth with Mentoach.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ config('app.name', 'Mentoach') }}">
        <meta name="twitter:description" content="Connect with experienced mentors and accelerate your career growth with Mentoach.">

        <link rel="canonical" href="{{ url()->current() }}">
        <title inertia>{{ config('app.name', 'Mentoach') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
