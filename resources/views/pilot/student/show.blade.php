@extends('layouts.app')

@section('title', 'Profile - Talentis')

@section('content')
    <div class="flex flex-col justify-center items-center min-h-[75vh]">
        <div class="max-w-5xl w-full p-4 sm:p-6 flex flex-col lg:flex-row lg:gap-10 items-stretch">

            <!-- Section Profil -->
            <div class="card bg-base-100 text-neutral-content py-12 sm:py-14 rounded-lg shadow-lg border w-full lg:w-1/3 flex flex-col justify-between">
                <h3 class="text-lg sm:text-xl font-bold text-center text-neutral mb-6">Profil</h3>
                <div class="flex flex-col items-center space-y-6 sm:space-y-8">
                    <div class="avatar">
                        <div class="w-32 sm:w-36 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img src="{{ Storage::url($user->profile_picture_path) }}" alt="Photo de profil">
                        </div>
                    </div>

                    <h3 class="text-lg sm:text-xl font-bold">{{ $user->first_name ?? '' }} {{ $user->name ?? ''}}</h3>
                    <p class="text-sm sm:text-base font-medium">📅 Date de naissance : <span class="font-semibold">{{$user->birthdate ?? ''}}</span></p>
                    <p class="text-sm sm:text-base font-medium">🎓 Promotion : <span class="font-semibold">{{$user->promotion->promotion_code ?? ''}}</span></p>
                    <p class="text-sm sm:text-base font-medium">🏠 Adresse : <span class="font-semibold">
                            {{ optional($user->addresses)->postal_code ?? '' }} {{ optional($user->addresses)->city ?? '' }}</span>
                    </p>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="card bg-base-100 shadow-lg border w-full lg:w-2/3 p-6 md:p-8">
                <h3 class="text-xl font-bold text-center text-neutral mb-6">Statistiques</h3>

                <div class="stats stats-vertical sm:stats-horizontal w-full">
                    <!-- Annonces Likées -->
                    <div class="stat w-full sm:w-1/3">
                        <div class="stat-figure text-error">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 stroke-current" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <div class="stat-title">Annonces Likées</div>
                        <div class="stat-value text-error">{{ $wishlistCount }}</div>
                        <div class="stat-desc">Ajoutées en favoris</div>
                    </div>

                    <!-- Annonces Postulées -->
                    <div class="stat w-full sm:w-1/3">
                        <div class="stat-figure text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 stroke-current" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="stat-title">Annonces Postulées</div>
                        <div class="stat-value text-success">{{ $appliesCount }}</div>
                        <div class="stat-desc">Toutes ses candidatures</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wishlist et Candidatures -->
        <div class="max-w-5xl w-full px-4 sm:px-6 mt-8 flex flex-col gap-6 lg:flex-row lg:gap-10">

            <!-- Wishlist -->
            <div class="card bg-base-100 rounded-lg shadow-lg border w-full lg:w-1/2 p-6">
                <h3 class="text-xl font-bold text-center text-neutral mb-4">3 dernière offres mise en Favoris</h3>

                @if ($wishlist->isEmpty())
                    <div class="text-center text-gray-500">Aucune offre ajoutée en favoris.</div>
                @else
                    <ul class="space-y-4">
                        @foreach ($wishlist as $offre)
                            <li class="border p-4 rounded-lg bg-base-200">
                                <a href="{{ route('offer.show', $offre) }}" class="text-primary underline font-semibold text-lg">{{ $offre->title }}</a>
                                <p class="text-sm text-gray-600">{{ $offre->companies->name ?? 'Inconnue' }}</p>
                                <p class="text-sm text-gray-500">Ajouté le : {{ $offre->pivot->created_at->format('d/m/Y') }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Candidatures -->
            <div class="card bg-base-100 rounded-lg shadow-lg border w-full lg:w-1/2 p-6">
                <h3 class="text-xl font-bold text-center text-neutral mb-4">3 dernière Candidatures</h3>

                @if ($applies->isEmpty())
                    <div class="text-center text-gray-500">Vous n'avez pas encore postulé à une offre.</div>
                @else
                    <ul class="space-y-4">
                        @foreach ($applies as $candidature)
                            <li class="border p-4 rounded-lg bg-base-200">
                                <h4 class="font-semibold text-lg">{{ $candidature->title }}</h4>
                                <p class="text-sm text-gray-600">{{ $candidature->companies->name ?? 'Inconnue' }}</p>
                                <p class="text-sm text-gray-500">Postulé le : {{ $candidature->pivot->created_at->format('d/m/Y à H:i') }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
        <div class="flex justify-start mt-6">
            <a href="{{ route('student.index') }}" class="btn btn-secondary">
                ← Retour
            </a>
        </div>
    </div>
@endsection
