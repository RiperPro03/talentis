@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Statistiques des Offres</h1>

        <!-- Nombre d'offres par secteur -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Nombre d'offres par secteur</h2>
            <div class="hidden sm:block">
                <table class="w-full mt-3 border-collapse border border-gray-300">
                    <thead>
                    <tr class="bg-gray-200">
                        @foreach($sectorOffers as $sector)
                            <th class="p-3 border border-gray-300">{{ $sector->sector_name }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($sectorOffers as $sector)
                            <td class="p-3 border border-gray-300 text-center font-bold">{{ $sector->count }}</td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $sectorOffers->links() }}
                </div>
            </div>
            <div class="sm:hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-3">
                @foreach($sectorOffers as $sector)
                    <div class="bg-white shadow-lg rounded-lg p-4 text-center">
                        <h3 class="text-xl font-semibold text-gray-700">{{ $sector->sector_name }}</h3>
                        <p class="text-lg font-bold text-blue-600">{{ $sector->count }} offres</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Nombre d'offres par compétence -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Nombre d'offres par compétence</h2>
            <div class="hidden sm:block">
                <table class="w-full mt-3 border-collapse border border-gray-300">
                    <thead>
                    <tr class="bg-gray-200">
                        @foreach($skillsOffers as $skill)
                            <th class="p-3 border border-gray-300">{{ $skill->skill_name }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($skillsOffers as $skill)
                            <td class="p-3 border border-gray-300 text-center font-bold">{{ $skill->count }}</td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $skillsOffers->links() }}
                </div>
            </div>
            <div class="sm:hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-3">
                @foreach($skillsOffers as $skill)
                    <div class="bg-white shadow-lg rounded-lg p-4 text-center">
                        <h3 class="text-xl font-semibold text-gray-700">{{ $skill->skill_name }}</h3>
                        <p class="text-lg font-bold text-green-600">{{ $skill->count }} offres</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top 3 des offres les plus en wishlist -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
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

        <!-- Offres de stage -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-700">Offres de stage</h2>
            <p class="mt-3 text-lg">Plus de 3 mois : <span class="font-bold text-green-600">{{ $internships3Months }}</span> offres</p>
            <p class="mt-3 text-lg">Plus de 6 mois : <span class="font-bold text-red-600">{{ $internships6Months }}</span> offres</p>
        </div>

        <!-- Top 3 des offres les mieux payées -->
        <div class="bg-white shadow-lg rounded-lg p-6">
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
