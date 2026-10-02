<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | GlobalPark Pathfinder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dashboard-page">
    <main class="dashboard-card">
        <img class="login-logo" src="{{ asset('assets/pathfinder/globalpark-logo.png') }}" alt="GlobalPark">
        <h1>Welcome to GlobalPark Pathfinder</h1>
        <p>You are signed in as {{ auth()->user()->email }}.</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-button" type="submit">Log out</button>
        </form>
    </main>
</body>
</html>
