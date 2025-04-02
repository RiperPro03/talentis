@extends('layouts.app')

@section('title', 'Candidatures - Talentis')

@section('content')
    <div class="container mx-auto py-6 px-4">

        @if (session('success'))
            <div class="alert alert-success shadow-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error shadow-lg mb-4">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
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

        <h1 class="text-lg md:text-4xl font-bold mb-6 text-center">Candidatures</h1>

        <form action="{{ route('pilot.apply.index') }}" method="GET" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <!-- Titre de l'offre -->
                <div class="form-control w-full">
                    <label class="label" for="offer-title">
                        <span class="label-text">Titre de l'offre</span>
                    </label>
                    <input type="text" name="offer_title" id="offer-title" value="{{ request('offer_title') }}"
                        class="input input-bordered w-full" placeholder="Ex : Développeur, UX Designer..." />
                </div>

                <!-- Nom ou prénom du candidat -->
                <div class="form-control w-full">
                    <label class="label" for="candidate">
                        <span class="label-text">Nom ou prénom du candidat</span>
                    </label>
                    <input type="text" name="candidate" id="candidate" value="{{ request('candidate') }}"
                        class="input input-bordered w-full" placeholder="Ex : Marie, Dupont" />
                </div>

                <!-- Filtres par entreprise (multi-select) -->
                <x-multi-select-filter name="company" label="Entreprise" :items="$companies" key="name" />
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>

        @foreach ($offers as $offer)
            @foreach ($offer->applies as $user)
                <!-- Modal de confirmation -->
                <dialog id="modal-{{ $offer->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                        <p class="py-4">
                            Êtes-vous sûr de vouloir retirer la candidature du candidat
                            <strong>{{ $user->first_name }} {{ $user->name }}</strong> pour le poste
                            de :<strong>{{ $offer->title }}</strong> ?
                        </p>
                        <div class="modal-action">
                            <form method="dialog">
                                <button class="btn">Annuler</button>
                            </form>
                            <form action="{{ route('pilot.apply.remove', [$offer, $user]) }}" method="POST">
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
        @endforeach

        @if ($offers->isEmpty())
            <p class="text-center text-gray-500">Aucune candidature enregistrée.</p>
        @else
            {{-- Version Mobile --}}
            <div class="md:hidden flex flex-col gap-4">
                @foreach ($offers as $offer)
                    @foreach ($offer->applies as $user)
                        <div class="card bg-white shadow-md rounded-lg p-4">
                            <h2 class="text-lg font-semibold mb-1">
                                {{ $offer->title }}
                            </h2>

                            <p class="text-gray-600 mb-1">
                                {{ $offer->companies->name }}
                            </p>

                            <p class="text-sm text-gray-700 mb-1">Candidat : <strong>{{ $user->first_name }}
                                    {{ $user->name }}</strong></p>

                            <div class="flex flex-wrap gap-1 mb-2">
                                @foreach ($offer->companies->addresses as $location)
                                    <div class="badge badge-ghost whitespace-nowrap">
                                        📍 {{ $location->city }}
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-sm text-gray-700 mb-1">
                                Soumis le : {{ $user->pivot->created_at->format('d/m/Y') }}
                            </div>

                            <div class="text-sm text-gray-700 mb-1">
                                Lettre :
                                {{ $user->pivot->cover_letter ? Str::limit($user->pivot->cover_letter, 80) : 'Non fournie' }}
                            </div>

                            <div class="flex flex-col gap-2 mt-4">
                                @if ($user->pivot->curriculum_vitae)
                                    <a href="{{ Storage::url($user->pivot->curriculum_vitae) }}" target="_blank"
                                        class="btn btn-outline btn-sm">Voir CV</a>
                                @else
                                    <span class="text-sm text-gray-500 italic">CV non fourni</span>
                                @endif

                                <button class="btn btn-error btn-sm"
                                    onclick="document.getElementById('modal-{{ $offer->id }}').showModal()">
                                    Retirer
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>

            {{-- Version Desktop --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="table w-full border-collapse border bg-white text-sm md:text-base">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="border px-4 py-2 text-center">Poste</th>
                            <th class="border px-4 py-2 text-center">Entreprise</th>
                            <th class="border px-4 py-2 text-center">Candidat</th>
                            <th class="border px-4 py-2 text-center">Localisation</th>
                            <th class="border px-4 py-2 text-center">CV</th>
                            <th class="border px-4 py-2 text-center">Lettre</th>
                            <th class="border px-4 py-2 text-center">Soumis le</th>
                            <th class="border px-4 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offers as $offer)
                            @foreach ($offer->applies as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2">{{ $offer->title }}</td>
                                    <td class="border px-4 py-2">{{ $offer->companies->name }}</td>
                                    <td class="border px-4 py-2">{{ $user->first_name }} {{ $user->name }}</td>
                                    <td class="border px-4 py-2">
                                        @foreach ($offer->companies->addresses as $location)
                                            <div class="badge badge-ghost whitespace-nowrap flex items-center">
                                                📍 {{ $location->city }}
                                            </div>
                                        @endforeach
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        @if ($user->pivot->curriculum_vitae)
                                            <a href="{{ Storage::url($user->pivot->curriculum_vitae) }}" target="_blank"
                                                class="btn btn-outline btn-sm">Voir CV</a>
                                        @else
                                            <span class="text-sm text-gray-500 italic">Non fourni</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ $user->pivot->cover_letter ? Str::limit($user->pivot->cover_letter, 80) : 'Non fournie' }}
                                    </td>
                                    <td class="border px-4 py-2 text-center text-gray-500">
                                        {{ $user->pivot->created_at->format('d/m/Y') }}
                                    </td>

                                    <td class="border px-4 py-2 text-center">
                                        <button class="btn btn-error btn-sm"
                                            onclick="document.getElementById('modal-{{ $offer->id }}').showModal()">
                                            Retirer
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $offers->links() }}
            </div>
        @endif
    </div>
@endsection
