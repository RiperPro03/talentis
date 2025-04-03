@extends('layouts.app')

@section('title', 'Statistiques des Offres - Talentis')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-10">
        <h1 class="text-4xl font-bold text-center text-primary mb-12">📈 Statistiques des Offres</h1>

        {{-- 1. Nombre d'offres par secteur --}}
        <section class="relative w-full max-w-6xl mx-auto mt-20 mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Offres par secteur</h2>
            <div class="carousel-wrapper">
                <div class="carousel flex gap-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory px-4 scroll-smooth">
                    @foreach($sectorOffers as $sector)
                        <div class="carousel-item w-80 snap-center shrink-0 mx-10">
                            <div class="card bg-base-100 shadow-xl flex flex-col h-full w-full">
                                <div class="stats shadow flex-grow">
                                    <div class="stat text-center">
                                        <div class="stat-title text-lg">{{ $sector->sector_name }}</div>
                                        <div class="stat-value text-success text-4xl">{{ $sector->count }}</div>
                                        <div class="stat-desc text-sm">offres disponibles</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="carousel-prev hidden lg:flex absolute left-0 top-1/2 btn btn-circle btn-primary">❮</button>
                <button class="carousel-next hidden lg:flex absolute right-0 top-1/2 btn btn-circle btn-primary">❯</button>
            </div>
        </section>

        {{-- 2. Nombre d'offres par compétence --}}
        <section class="relative w-full max-w-6xl mx-auto mt-20 mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Offres par compétence</h2>
            <div class="carousel-wrapper">
                <div class="carousel flex gap-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory px-4 scroll-smooth">
                    @foreach($skillsOffers as $skill)
                        <div class="carousel-item w-80 snap-center shrink-0 mx-10">
                            <div class="card bg-base-100 shadow-xl flex flex-col h-full w-full">
                                <div class="stats shadow flex-grow">
                                    <div class="stat text-center">
                                        <div class="stat-title text-lg">{{ $skill->skill_name }}</div>
                                        <div class="stat-value text-error text-4xl">{{ $skill->count }}</div>
                                        <div class="stat-desc text-sm">offres demandées</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="carousel-prev hidden lg:flex absolute left-0 top-1/2 btn btn-circle btn-primary">❮</button>
                <button class="carousel-next hidden lg:flex absolute right-0 top-1/2 btn btn-circle btn-primary">❯</button>
            </div>
        </section>


        {{-- 3. Top 3 des offres en wishlist --}}
        <section class="mb-16">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">🔥 Offres les plus en wishlist</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($topWishlistedOffers as $offer)
                    <div class="card bg-base-100 shadow-lg border">
                        <div class="card-body items-center text-center">
                            <h3 class="card-title">
                                <a href="{{ route('offer.show', $offer->id) }}" class="text-primary hover:underline">
                                    {{ $offer->title }}
                                </a>
                            </h3>
                            <p class="text-gray-700">Entreprise : <strong>{{ $offer->company_name }}</strong></p>
                            <p class="text-success font-bold text-lg">{{ $offer->count }} wishlist(s)</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- 4. Stages par durée --}}
        <section class="mb-16">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">📅 Stages par durée</h2>
            <div class="stats stats-vertical lg:stats-horizontal shadow w-full">
                <div class="stat">
                    <div class="stat-title">Stage > 3 mois</div>
                    <div class="stat-value text-success">{{ $internships3Months }}</div>
                </div>
                <div class="stat">
                    <div class="stat-title">Stage > 6 mois</div>
                    <div class="stat-value text-error">{{ $internships6Months }}</div>
                </div>
            </div>
        </section>

        {{-- 5. Top 3 des offres les mieux payées --}}
        <section class="mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">💰 Offres les mieux rémunérées</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($topPayingOffers as $offer)
                    <div class="card bg-white border shadow-md">
                        <div class="card-body text-center">
                            <h3 class="card-title">
                                <a href="{{ route('offer.show', $offer->id) }}" class="text-blue-600 hover:underline">
                                    {{ $offer->title }}
                                </a>
                            </h3>
                            <p class="text-gray-700">Entreprise : <strong>{{ $offer->company_name }}</strong></p>
                            <p class="text-green-600 text-lg font-bold">{{ number_format($offer->base_salary, 2) }} €</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
