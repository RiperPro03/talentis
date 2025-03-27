@extends('layouts.app')

@section('title', 'Mes Candidatures - Talentis')

@section('content')
    <div class="container mx-auto py-6 px-4">

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

        <h1 class="text-lg md:text-4xl font-bold mb-6 text-center">Mes Candidatures</h1>

        @foreach($applies as $offer)
            <!-- Modal de confirmation -->
            <dialog id="modal-{{ $offer->id }}" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                    <p class="py-4">
                        Êtes-vous sûr de vouloir retirer votre candidature à
                        <strong>{{ $offer->title }}</strong> ?
                    </p>
                    <div class="modal-action">
                        <form method="dialog">
                            <button class="btn">Annuler</button>
                        </form>
                        <form action="{{ route('apply.remove', $offer) }}" method="POST">
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

        @if($applies->isEmpty())
            <p class="text-center text-gray-500">Vous n'avez encore postulé à aucune offre.</p>
        @else
                <div class="md:hidden flex flex-col gap-4">
                    @foreach($applies as $offer)
                        <div class="bg-white shadow-md rounded-lg p-4">
                            <!-- Titre du poste -->
                            <h2 class="text-lg font-semibold">
                                <a href="{{ route('offer.show', $offer) }}" class="text-primary hover:underline">
                                    {{ $offer->title }}
                                </a>
                            </h2>

                            <!-- Entreprise -->
                            <p class="text-gray-600">
                                <a href="{{ route('company.show', $offer->companies->id) }}" class="hover:underline">
                                    {{ $offer->companies->name }}
                                </a>
                            </p>

                            <!-- Localisations -->
                            <div class="flex flex-wrap gap-1 mt-2">
                                @foreach($offer->companies->addresses as $location)
                                    <div class="badge badge-ghost whitespace-nowrap flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="red" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 11c1.326 0 2.4-.93 2.4-2.077S13.326 6.846 12 6.846s-2.4.93-2.4 2.077S10.674 11 12 11z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 22s8-6.33 8-11.23A8 8 0 104 10.77C4 15.67 12 22 12 22z"></path>
                                        </svg>
                                        {{ $location->city }}
                                    </div>
                                @endforeach
                            </div>

                            <!-- Lettre de motivation -->
                            <div class="mt-2 text-sm text-gray-700">
                                {{ Str::limit($offer->pivot->cover_letter, 80) ?? 'Non fournie' }}
                            </div>

                            <!-- Actions -->
                            <div class="mt-4 flex flex-col gap-2">
                                <a href="{{ Storage::url($offer->pivot->curriculum_vitae) }}"
                                   target="_blank" class="btn btn-outline btn-sm w-full">
                                    Voir mon CV
                                </a>

                                <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $offer->id }}').showModal()">
                                    Retirer
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="hidden md:block overflow-x-auto">
                <table class="table w-full border-collapse border bg-white text-sm md:text-base">
                    <thead>
                    <tr class="bg-gray-50">
                        <th class="border px-4 py-2 text-center">Poste</th>
                        <th class="border px-4 py-2 text-center">Entreprise</th>
                        <th class="border px-4 py-2 text-center">Localisation</th>
                        <th class="border px-4 py-2 text-center">CV</th>
                        <th class="border px-4 py-2 text-center">Lettre de motivation</th>
                        <th class="border px-4 py-2 text-center">Soumis le</th>
                        <th class="border px-4 py-2 text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($applies as $offer)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">
                                <a href="{{ route('offer.show', $offer) }}"
                                   class="font-bold text-primary hover:underline">
                                    {{ $offer->title }}
                                </a>
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('company.show', $offer->companies->id) }}"
                                   class="font-bold text-primary hover:underline">
                                    {{ $offer->companies->name }}
                                </a>
                            </td>
                            <td class="border px-4 py-2">
                                @foreach($offer->companies->addresses as $location)
                                    <div class="badge badge-xl badge-ghost whitespace-nowrap flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="red" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 11c1.326 0 2.4-.93 2.4-2.077S13.326 6.846 12 6.846s-2.4.93-2.4 2.077S10.674 11 12 11z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 22s8-6.33 8-11.23A8 8 0 104 10.77C4 15.67 12 22 12 22z"></path>
                                        </svg>
                                        {{ $location->city }}
                                    </div>
                                @endforeach
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <a href="{{ Storage::url($offer->pivot->curriculum_vitae) }}" target="_blank" class="btn btn-outline btn-sm">
                                    Voir CV
                                </a>
                            </td>

                            <td class="border px-4 py-2">
                                {{ Str::limit($offer->pivot->cover_letter, 80) ?? 'Non fournie' }}
                            </td>

                            <td class="border px-4 py-2 text-center text-gray-500">
                                {{ $offer->pivot->created_at->format('d/m/Y à H:i') }}
                            </td>

                            <td class="border px-4 py-2 text-center">
                                <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $offer->id }}').showModal()">
                                    Retirer
                                </button>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{ $applies->links() }}
        @endif
    </div>
@endsection
