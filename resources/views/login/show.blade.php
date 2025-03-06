<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex">
    <!-- Section Gauche : Formulaire -->
    <div class="w-full md:w-1/2 h-screen flex items-center justify-center bg-base-200">
        <div class="card w-full max-w-6xl bg-base-100 shadow-xl p-6">
            <div class="w-full flex flex-col items-center md:items-start p-6">
                <h1 class="text-3xl font-bold text-center text-primary mb-6">Connexion</h1>

                <!-- Formulaire -->
                <form action="#" method="POST" class="space-y-6 w-full max-w-sm mx-auto">
                    @csrf
                    <x-form-question question="Adresse e-mail" :answers="[1]" />
                    <x-form-question question="Mot de passe" :answers="[1]" />

                    <!-- Bouton de soumission -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-full">
                            Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Section Droite : Image -->
    <div class="hidden md:block w-1/2 h-screen">
        <img src="{{ asset('img/logo/logo.png') }}" alt="Image de fond"
            class="w-full h-full object-cover">
    </div>
</body>

</html>
