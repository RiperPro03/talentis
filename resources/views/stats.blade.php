@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Statistiques des Offres</h1>

        <!-- Nombre d'offres par secteur -->

        <div class="relative w-full max-w-6xl mx-auto mt-10 mb-20 ">
            <h2 class="text-2xl font-semibold text-gray-700">Nombres d'offres par secteur</h2>


            <div class="carousel-wrapper">
                <div class="carousel flex gap-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory px-4 scroll-smooth">
                    @foreach($sectorOffers as $sector)
                        <div class="carousel-item w-80 snap-center shrink-0 mx-10">
                            <div class="card bg-base-100 shadow-xl flex flex-col h-full w-full">
                                <div class="stats shadow flex-grow">
                                    <div class="stat">
                                        <div class="stat-title">{{$sector->sector_name}}</div>
                                        <div class="stat-value text-success">{{$sector->count}}</div>
                                        <div class="stat-desc">offres</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>

                <button class="carousel-prev hidden lg:flex absolute left-0 top-1/2 btn btn-circle btn-primary ">❮</button>
                <button class="carousel-next hidden lg:flex absolute right-0 top-1/2 btn btn-circle btn-primary">❯</button>

            </div>
        </div>


        <!-- Nombre d'offres par compétence -->
        <div class="relative w-full max-w-6xl mx-auto mt-20 mb-10">
            <h2 class="text-2xl font-semibold text-gray-700">Nombre d'offres par compétences</h2>
            <div class="carousel-wrapper">
                <div class="carousel flex gap-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory px-4 scroll-smooth">
                    @foreach($skillsOffers as $skill)
                        <div class="carousel-item w-80 snap-center shrink-0 mx-10">
                            <div class="card bg-base-100 shadow-xl flex flex-col h-full w-full">
                                <div class="stats shadow flex-grow">
                                    <div class="stat">
                                        <div class="stat-title">{{$skill->skill_name}}</div>
                                        <div class="stat-value text-error">{{$skill->count}}</div>
                                        <div class="stat-desc">offres</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="carousel-prev hidden lg:flex absolute left-0 top-1/2 btn btn-circle btn-primary ">❮</button>
                <button class="carousel-next hidden lg:flex absolute right-0 top-1/2 btn btn-circle btn-primary">❯</button>
            </div>
        </div>

        <!-- Top 3 des offres les plus en wishlist -->
        <div class="rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Top 3 des offres les plus en wishlist</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-3">
                @foreach($topWishlistedOffers as $offer)
                    <div class="bg-white shadow-lg rounded-lg p-4 text-center">
                        <h3 class="text-xl font-semibold text-gray-700">
                            <a href="{{ route('offer.show', $offer->id) }}" class="text-blue-600 hover:underline">{{ $offer->title }}</a>
                        </h3>
                        <p class="text-lg text-gray-700">Entreprise: <span class="font-bold">{{ $offer->company_name }}</span></p>
                        <p class="text-lg font-bold text-blue-600">{{ $offer->count }} wishlists</p>
                    </div>
                @endforeach
            </div>
        </div>

        <h2 class="text-2xl font-semibold text-gray-700">Stages par durée</h2>

        <!-- Offres de stage -->
        <div class="stats shadow mt-5 mb-10">
            <div class="stat">

                <div class="stat-title">Stage de plus de 3 mois</div>
                <div class="stat-value text-success">{{$internships3Months}}</div>

            </div>

            <div class="stat">

                <div class="stat-title">Stage de plus de 6 mois</div>
                <div class="stat-value  text-error">{{$internships3Months}}</div>

            </div>

        </div>

        <!-- Top 3 des offres les mieux payées -->
        <div class="rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700">Top 3 des offres les mieux payées</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-3">
                @foreach($topPayingOffers as $offer)
                    <div class="bg-white shadow-lg rounded-lg p-4 text-center">
                        <h3 class="text-xl font-semibold text-gray-700">
                            <a href="{{ route('offer.show', $offer->id) }}" class="text-blue-600 hover:underline">{{ $offer->title }}</a>
                        </h3>
                        <p class="text-lg text-gray-700">Entreprise: <span class="font-bold">{{ $offer->company_name }}</span></p>
                        <p class="text-lg font-bold text-green-600">{{ number_format($offer->base_salary, 2) }}€</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
