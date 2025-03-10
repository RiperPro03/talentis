<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="max-w-4xl mx-auto p-4 sm:p-6">
        <div class="card bg-base-100 shadow-xl p-4 sm:p-6">
            <h2 class="text-xl sm:text-2xl font-bold mb-4 text-center">Mon Profil</h2>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="stat bg-primary text-primary-content rounded-lg p-4 text-center">
                    <div class="stat-title text-sm sm:text-base">Annonces Likées</div>
                    <div class="stat-value text-lg sm:text-2xl">74</div>
                </div>
                <div class="stat bg-secondary text-secondary-content rounded-lg p-4 text-center">
                    <div class="stat-title text-sm sm:text-base">Annonces Postulées</div>
                    <div class="stat-value text-lg sm:text-2xl">46</div>
                </div>
                <div class="stat bg-accent text-accent-content rounded-lg p-4 text-center">
                    <div class="stat-title text-sm sm:text-base">Réponses Positives</div>
                    <div class="stat-value text-lg sm:text-2xl">3</div>
                </div>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-center">
                <a href="#" class="btn btn-primary w-full sm:w-auto">🔍 Recherche Entreprises</a>
                <a href="#" class="btn btn-secondary w-full sm:w-auto">❤️ Ma Wishlist</a>
                <a href="#" class="btn btn-accent w-full sm:w-auto">📜 Mes Candidatures</a>
            </div>
        </div>
    </div>
</body>

</html>
