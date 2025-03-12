<!DOCTYPE html>
<html lang="en">

@extends('layouts.dashboard-admin')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Home Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-200">

    <!-- Script pour gérer la visibilité de la sidebar et du header -->
    <script>
        window.addEventListener("scroll", function() {
            let statsTitle = document.getElementById("statsTitle");
            if (window.scrollY > 50) {
                statsTitle.classList.add("opacity-0");
            } else {
                statsTitle.classList.remove("opacity-0");
            }
        });
    </script>

    <div class="md:h-screen flex">

        <!-- Contenu principal -->
        <main class="flex-1 p-10 md:ml-64 mt-16">
            <div class="w-full max-w-7xl mx-auto">
                <!-- Titre des statistiques avec position dynamique sur défilement -->
                <h1 id="statsTitle"
                    class="text-4xl font-bold text-gray-800 mb-8 text-center sm:text-2xl z-40 bg-white py-2 px-4 shadow-md transition-all duration-300 ease-in-out sm:mt-20 lg:text-5xl">
                    📊 Statistiques du site
                </h1>

                <!-- Conteneur des statistiques avec flex pour répartir les espaces -->
                <div class="flex flex-wrap justify-center gap-6 mt-16 sm:mt-24">
                    <!-- Première ligne : 3 stats -->
                    <div class="w-full sm:w-1/3 lg:w-1/4 p-6 bg-white shadow-lg rounded-xl border text-center">
                        <div class="stat-title text-lg sm:text-base lg:text-xl">Nombre de Pilotes</div>
                        <div class="stat-value text-blue-600 text-5xl sm:text-3xl lg:text-6xl">120</div>
                        <div class="stat-desc text-gray-500 lg:text-lg">Mis à jour récemment</div>
                    </div>

                    <div class="w-full sm:w-1/3 lg:w-1/4 p-6 bg-white shadow-lg rounded-xl border text-center">
                        <div class="stat-title text-lg sm:text-base lg:text-xl">Nombre d'Étudiants</div>
                        <div class="stat-value text-green-600 text-5xl sm:text-3xl lg:text-6xl">450</div>
                        <div class="stat-desc text-gray-500 lg:text-lg">↗︎ +10 cette semaine</div>
                    </div>

                    <div class="w-full sm:w-1/3 lg:w-1/4 p-6 bg-white shadow-lg rounded-xl border text-center">
                        <div class="stat-title text-lg sm:text-base lg:text-xl">Offres publiées</div>
                        <div class="stat-value text-yellow-600 text-5xl sm:text-3xl lg:text-6xl">78</div>
                        <div class="stat-desc text-gray-500 lg:text-lg">↘︎ -5 cette semaine</div>
                    </div>

                    <!-- Deuxième ligne : 2 stats -->
                    <div class="w-full sm:w-1/2 lg:w-1/4 p-6 bg-white shadow-lg rounded-xl border text-center">
                        <div class="stat-title text-lg sm:text-base lg:text-xl">Entreprises partenaires</div>
                        <div class="stat-value text-purple-600 text-5xl sm:text-3xl lg:text-6xl">35</div>
                        <div class="stat-desc text-gray-500 lg:text-lg">↗︎ +3 ce mois</div>
                    </div>

                    <div class="w-full sm:w-1/2 lg:w-1/4 p-6 bg-white shadow-lg rounded-xl border text-center">
                        <div class="stat-title text-lg sm:text-base lg:text-xl">Moyenne Offres/Jour</div>
                        <div class="stat-value text-red-600 text-5xl sm:text-3xl lg:text-6xl">5.2</div>
                        <div class="stat-desc text-gray-500 lg:text-lg">Stable cette semaine</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

</html>
