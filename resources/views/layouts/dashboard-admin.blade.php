<!-- resources/views/layouts/dashboardLayout.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-200">

    <div class="lg:flex">

        <!-- Sidebar pour PC -->
        <aside class="w-64 bg-base-100 p-5 flex flex-col fixed top-0 left-0 h-full z-30 hidden lg:block">
            <h2 class="text-xl font-bold text-primary mb-6">📌 Dashboard</h2>
            <ul class="menu space-y-2">
                <li><a href="{{ url('/dashboard/home') }}" class="font-bold">🏠 Home</a></li>
                <li><a href="pilot" class="font-bold">👤 Pilotes</a></li>
                <li><a href="offer" class="font-bold">📦 Offres</a></li>
                <li><a href="company" class="font-bold">🏢 Entreprises</a></li>
                <li><a href="student" class="font-bold">🎓 Étudiants</a></li>
                <li><a href="apply" class="font-bold">📋 Candidatures</a></li>
                <li><a href="wishlist" class="font-bold">💼 Wishlist</a></li>
            </ul>
        </aside>

        <!-- Contenu principal -->
        <main class="lg:flex-1 p-10 md:ml-64 mt-16 lg:mt-0 pb-16 lg:pb-0">
            @yield('content')
        </main>

    </div>

    <!-- Carrousel dans le Header pour Mobile -->
    <header class="lg:hidden fixed bottom-0 left-0 w-full bg-base-100 z-50 p-4 flex items-center justify-between shadow-md">
        <div class="overflow-x-auto flex justify-between">
            <a href="{{ url('/dashboard/home') }}" class="font-bold text-lg px-4 py-2">🏠 Home</a>
            <a href="/dashboard?table=pilot" class="font-bold text-lg px-4 py-2">👤 Pilotes</a>
            <a href="/dashboard?table=offer" class="font-bold text-lg px-4 py-2">📦 Offres</a>
            <a href="/dashboard?table=company" class="font-bold text-lg px-4 py-2">🏢 Entreprises</a>
            <a href="/dashboard?table=student" class="font-bold text-lg px-4 py-2">🎓 Étudiants</a>
            <a href="/dashboard?table=apply" class="font-bold text-lg px-4 py-2">📋 Candidatures</a>
            <a href="/dashboard?table=wishlist" class="font-bold text-lg px-4 py-2">💼 Wishlist</a>
        </div>
    </header>

</body>

</html>
