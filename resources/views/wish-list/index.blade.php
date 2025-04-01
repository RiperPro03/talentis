@extends('layouts.app')

@section('title', 'Mes favoris - Talentis')

@section('content')
    <div class="container mx-auto py-6 px-4">
{{--        <!-- Bouton de retour -->--}}
{{--        <div class="flex justify-start mb-4">--}}
{{--            <a href="{{ url()->previous() }}" class="btn btn-secondary">← Retour</a>--}}
{{--        </div>--}}

        @if ($errors->any())
            <div class="alert alert-error shadow-lg mb-4">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <div>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif


        <h1 class="text-lg md:text-4xl font-bold mb-6 text-center">Mes Favoris</h1>

        @foreach($wishlist as $offer)
            <!-- Modal de confirmation -->
            <dialog id="modal-{{ $offer->id }}" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                    <p class="py-4">
                        Êtes-vous sûr de vouloir retirer de la liste des favoris l'offre
                        <strong>{{ $offer->title }}</strong> ?
                    </p>
                    <div class="modal-action">
                        <form method="dialog">
                            <button class="btn">Annuler</button>
                        </form>
                        <form action="{{ route('wishlist.remove', $offer) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-error">Confirmer</button>
                        </form>
                    </div>
                </div>

                <!-- Ce backdrop ferme le modal si on clique à l'extérieur -->
                <form method="dialog" class="modal-backdrop">
                    <button class="cursor-default">Fermer</button>
                </form>
            </dialog>
        @endforeach

        @if($wishlist->isEmpty())
            <p class="text-center text-gray-500">Aucune offre ajoutée à votre liste de favoris.</p>
        @else
            <!-- Version Mobile: Affichage en cartes -->
            <div class="md:hidden flex flex-col gap-4">
                @foreach($wishlist as $offer)
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h2 class="text-lg font-semibold">{{ $offer->title }}</h2>
                        <p class="text-gray-600">{{ $offer->companies->name }}</p>
                        @foreach($offer->companies->addresses as $location)
                            <div class="badge badge-xl badge-ghost whitespace-nowrap flex items-center">
                                <svg class="w-4 h-4 mr-1 inline-block" fill="none" stroke="red" stroke-width="2"
                                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 11c1.326 0 2.4-.93 2.4-2.077S13.326 6.846 12 6.846s-2.4.93-2.4 2.077S10.674 11 12 11z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 22s8-6.33 8-11.23A8 8 0 104 10.77C4 15.67 12 22 12 22z">
                                    </path>
                                </svg>
                                {{ $location->city }}
                            </div>
                        @endforeach
                        <p class="text-gray-600">{{ $offer->type }}</p>

                        <!-- Actions -->
                        <div class="mt-3 flex justify-between">
                            <a href="{{ route('offer.show', $offer) }}" class="btn btn-primary btn-sm">Voir</a>
                            <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $offer->id }}').showModal()">
                                Retirer
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Version Desktop: Affichage en tableau -->
            <div class="hidden md:block overflow-x-auto">
                <table class="table w-full border-collapse border bg-white text-sm md:text-base">
                    <thead>
                    <tr class="bg-gray-50">
                        <th class="border px-4 py-2 text-center text-lg">Poste</th>
                        <th class="border px-4 py-2 text-center text-lg">Entreprise</th>
                        <th class="border px-4 py-2 text-center text-lg">Localisation</th>
                        <th class="border px-4 py-2 text-center text-lg">Type d'offre</th>
                        <th class="border px-4 py-2 text-center text-lg">Ajouté le</th>
                        <th class="border px-4 py-2 text-center text-lg">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($wishlist as $offer)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $offer->title }}</td>
                            <td class="border px-4 py-2">{{ $offer->companies->name }}</td>
                            <td class="border px-4 py-2">
                                @foreach($offer->companies->addresses as $location)
                                    <div class="badge badge-xl badge-ghost whitespace-nowrap flex items-center">
                                        <svg class="w-4 h-4 mr-1 inline-block" fill="none" stroke="red" stroke-width="2"
                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 11c1.326 0 2.4-.93 2.4-2.077S13.326 6.846 12 6.846s-2.4.93-2.4 2.077S10.674 11 12 11z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 22s8-6.33 8-11.23A8 8 0 104 10.77C4 15.67 12 22 12 22z">
                                            </path>
                                        </svg>
                                        {{ $location->city }}
                                    </div>
                                @endforeach
                            </td>

                            <td class="border px-4 py-2">{{ $offer->type }}</td>

                            <td class="border px-4 py-2 text-center text-gray-500">
                                {{ $offer->pivot->created_at->format('d/m/Y à H:i') }}
                            </td>

                            <td class="border px-4 py-2 flex gap-2 justify-center">
                                <a href="{{ route('offer.show', $offer) }}" class="btn btn-sm btn-primary">Voir</a>
                                <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $offer->id }}').showModal()">
                                    Retirer
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{ $wishlist->links() }}
        @endif
    </div>
@endsection
