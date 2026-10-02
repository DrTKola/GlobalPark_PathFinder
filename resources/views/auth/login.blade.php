<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign in | GlobalPark Pathfinder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page">
    <main class="login-card" aria-labelledby="login-title">
        <img class="login-logo" src="{{ asset('assets/pathfinder/globalpark-logo.png') }}" alt="GlobalPark">

        <header class="login-intro">
            <h1 id="login-title">GlobalPark Pathfinder</h1>
            <p>Sign in to manage your Pathfinder partner workspace</p>
        </header>

        @if ($errors->any())
            <div class="login-alert" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form class="login-form" method="POST" action="{{ route('login.store') }}" novalidate>
            @csrf

            <div class="form-field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="you@company.com" autocomplete="username" required autofocus>
            </div>

            <div class="form-field">
                <label for="password">Password</label>
                <div class="password-field">
                    <input id="password" name="password" type="password" placeholder="Enter your password" autocomplete="current-password" required>
                    <button class="password-toggle" type="button" aria-label="Show password" aria-pressed="false" data-password-toggle>
                        <img src="{{ asset('assets/pathfinder/eye.svg') }}" alt="">
                    </button>
                </div>
            </div>

            <button class="login-submit" type="submit" disabled data-login-submit>Log In</button>
        </form>

        <p class="login-footer">Need access? <span>Contact your Pathfinder administrator</span></p>
    </main>
</body>
</html>
