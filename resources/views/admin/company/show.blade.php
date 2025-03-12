<!DOCTYPE html>
<html lang="en">

@extends('layouts.dashboard-admin')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-200">

    <!-- Conteneur principal qui doit couvrir toute la page et la largeur -->
    <div class="min-h-screen w-full bg-base-200 flex">

        <!-- Contenu principal -->
        <main class="flex-1 p-6 lg:ml-64 mt-16 w-full"> <!-- Ajout de w-full pour que le contenu prenne toute la largeur -->

            @php
                $table = request('table', 'companies'); // Par défaut: table des utilisateurs
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

                <!-- Affichage des données avec ajout de overflow-x-auto -->
                <div class="overflow-x-auto">
                    @if($table == 'company')
                        @if ($company->isEmpty())
                            <p class="text-center text-gray-500">Aucune donnée disponible dans la table des entreprises.</p>
                        @else
                            @foreach($company as $item)
                                <x-table-row :item="$item" :table="'company'" />
                            @endforeach
                        @endif
                    @else
                        <p>Table non trouvée.</p>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- Script pour gérer la visibilité de la sidebar et du header -->
    <script>
        // Fonction pour cacher le titre au défilement
        window.addEventListener("scroll", function() {
            let statsTitle = document.getElementById("statsTitle");
            if (window.scrollY > 50) {
                statsTitle.classList.add("opacity-0"); // Le titre devient invisible
            } else {
                statsTitle.classList.remove("opacity-0"); // Le titre devient visible
            }
        });
    </script>

</body>

</html>
