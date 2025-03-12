@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-4 sm:p-6">
        <div class="space-y-10 sm:space-y-14"> <!-- Espacement amélioré -->

            <!-- Section Profil -->
            <div class="card bg-base-100 text-neutral-content py-10 sm:py-12 rounded-lg shadow-lg border text-center ">
                <div class="flex flex-col items-center">
                    <div class="avatar mb-6">
                        <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img src="#" alt="Photo de profil">
                        </div>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold">{{$user->first_name}} {{$user->name}}</h3>
                    <p class="text-sm sm:text-base">Date de naissance : {{$user->birthdate}}</p>
                    <p class="text-sm sm:text-base">Promotion : {{$user->promotion_id}}</p>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="card bg-base-100 p-6 py-10 sm:py-12 rounded-lg shadow-lg border">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-3 sm:gap-6">
                    <div class="stat bg-primary text-primary-content rounded-lg p-6 text-center">
                        <div class="stat-title text-sm sm:text-base">Annonces Likées</div>
                        <div class="stat-value text-lg sm:text-2xl">74</div>
                    </div>
                    <div class="stat bg-secondary text-secondary-content rounded-lg p-6 text-center">
                        <div class="stat-title text-sm sm:text-base">Annonces Postulées</div>
                        <div class="stat-value text-lg sm:text-2xl">46</div>
                    </div>
                    <div class="stat bg-accent text-accent-content rounded-lg p-6 text-center">
                        <div class="stat-title text-sm sm:text-base">Réponses Positives</div>
                        <div class="stat-value text-lg sm:text-2xl">3</div>
                    </div>
                </div>
            </div>

            <!-- Liens de navigation -->
            <div class="card bg-base-100 p-6 py-10 sm:py-12 rounded-lg shadow-lg border">
                <h3 class="text-lg sm:text-xl font-semibold text-center mb-6">Navigation</h3>
                <div class="flex flex-col gap-4 sm:flex-row sm:justify-center sm:gap-6">
                    <a href="#" class="btn btn-primary w-full sm:w-auto">🔍 Recherche Entreprises</a>
                    <a href="#" class="btn btn-secondary w-full sm:w-auto">❤️ Ma Wishlist</a>
                    <a href="#" class="btn btn-accent w-full sm:w-auto">📜 Mes Candidatures</a>
                </div>
            </div>

        </div>
    </div>
@endsection
