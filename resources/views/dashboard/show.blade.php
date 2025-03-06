<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-base-100 p-5 flex flex-col">
            <h2 class="text-xl font-bold text-primary mb-6">📌 Dashboard</h2>

            <ul class="menu space-y-2">
                <!-- Liens vers les tables existantes -->
                <li><a href="{{ url('/dashboard/home') }}" class="font-bold">🏠 Home</a></li>
                <li><a href="/dashboard?table=pilot" class="font-bold">👤 Pilotes</a></li>
                <li><a href="/dashboard?table=offer" class="font-bold">📦 Offres</a></li>
                <li><a href="/dashboard?table=company" class="font-bold">🏢 Entreprises</a></li>
                <li><a href="/dashboard?table=student" class="font-bold">🎓 Étudiants</a></li>
                <li><a href="/dashboard?table=apply" class="font-bold">📋 Candidatures</a></li>
                <li><a href="/dashboard?table=wishlist" class="font-bold">💼 Wishlist</a></li>
            </ul>
        </aside>

        <!-- Contenu principal -->
        <main class="flex-1 p-6 flex flex-col items-center bg-base-200">
            @php
                $table = request('table', 'pilot'); // Par défaut: table des utilisateurs
            @endphp

            <div class="w-full max-w-4xl bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    📋 Données de la table : <span class="text-primary">{{ ucfirst($table) }}</span>
                </h3>

                <!-- Bouton Ajouter - Redirige vers la page d'insertion -->
                <div class="mb-4 flex justify-end ">
                    <a href="{{ url($table . '/insert') }}" class="btn btn-primary text-white">
                        ➕ Ajouter une donnée
                    </a>
                </div>

                <!-- Affichage des données -->
                @if ($table == 'pilot')
                    @if ($pilot->isEmpty())
                        <p class="text-center text-gray-500">Aucune donnée disponible dans la table des pilotes.</p>
                    @else
                        <x-table-test :data="$pilot" />
                    @endif
                @elseif($table == 'offer')
                    @if ($offer->isEmpty())
                        <p class="text-center text-gray-500">Aucune donnée disponible dans la table des offres.</p>
                    @else
                        <x-table-test :data="$offer" />
                    @endif
                @elseif($table == 'company')
                    @if ($company->isEmpty())
                        <p class="text-center text-gray-500">Aucune donnée disponible dans la table des entreprises.</p>
                    @else
                        <x-table-test :data="$company" />
                    @endif
                @elseif($table == 'student')
                    @if ($student->isEmpty())
                        <p class="text-center text-gray-500">Aucune donnée disponible dans la table des étudiants.</p>
                    @else
                        <x-table-test :data="$student" />
                    @endif
                @elseif($table == 'apply')
                    @if ($apply->isEmpty())
                        <p class="text-center text-gray-500">Aucune donnée disponible dans la table des candidatures.</p>
                    @else
                        <x-table-test :data="$apply" />
                    @endif
                @elseif($table == 'wishlist')
                    @if ($wishlist->isEmpty())
                        <p class="text-center text-gray-500">Aucune donnée disponible dans la table wishlist.</p>
                    @else
                        <x-table-test :data="$wishlist" />
                    @endif
                @else
                    <p>Table non trouvée.</p>
                @endif
            </div>
        </main>
    </div>
</body>

</html>
