@extends('layouts.app')

@section('title', 'Wish-list d\'Offres')

@section('content')
    <div class="container mx-auto py-6 px-4">
        <!-- Bouton de retour en haut à gauche -->
        <div class="flex justify-start mb-4">
            <button onclick="window.history.back();" class="btn btn-secondary">← Retour</button>
        </div>

        <h1 class="text-2xl md:text-4xl font-bold mb-6 text-center">Wish-list d'Offres</h1>

        @if(empty($wishlist))
            <p class="text-center text-gray-500">Aucune offre ajoutée à votre wish-list.</p>
        @else
            <!-- Version Mobile: Affichage en cartes -->
            <div class="md:hidden flex flex-col gap-4">
                @foreach($wishlist as $offer)
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h2 class="text-lg font-semibold">{{ $offer['title'] }}</h2>
                        <p class="text-gray-600">{{ $offer['company'] }} - {{ $offer['location'] }}</p>
                        
                        <!-- Actions -->
                        <div class="mt-3 flex justify-between">
                            <a href="#" class="btn btn-primary btn-sm">Voir</a>
                            <button class="btn btn-error btn-sm">Retirer</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Version Desktop: Affichage en tableau -->
            <div class="hidden md:block overflow-x-auto">
                <table class="table w-full border-collapse border border-gray-200 text-sm md:text-base">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="border px-4 py-2">Poste</th>
                            <th class="border px-4 py-2">Entreprise</th>
                            <th class="border px-4 py-2">Localisation</th>
                            <th class="border px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishlist as $offer)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $offer['title'] }}</td>
                                <td class="border px-4 py-2">{{ $offer['company'] }}</td>
                                <td class="border px-4 py-2">{{ $offer['location'] }}</td>
                                <td class="border px-4 py-2 flex gap-2 justify-center">
                                    <a href="#" class="btn btn-sm btn-primary">Voir</a>
                                    <button class="btn btn-sm btn-error">Retirer</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
