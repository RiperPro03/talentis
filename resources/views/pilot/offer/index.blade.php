@extends('layouts.app')

@section('title', 'Gestion Offres d\'emploi - Talentis')

@section('content')
    <div class="max-w-6xl mx-auto py-8 px-4 space-y-6">

        @if (session('success'))
            <div class="alert alert-success shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 w-6 h-6" fill="none"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m-6 4V9m0 12A9 9 0 1 0 3 12a9 9 0 0 0 18 0 9 9 0 0 0-18 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error shadow-lg">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 w-6 h-6" fill="none"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <ul class="ml-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <h1 class="text-3xl font-bold text-center mb-6">Gestion des offres d'emploi</h1>

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('pilot.offer.index') }}"
              class="flex flex-col md:flex-row gap-4 justify-center items-center mb-8">
            <input type="text" name="title" placeholder="Titre" value="{{ request('title') }}"
                   class="input input-bordered w-full max-w-xs">
            <input type="number" name="min_salary" placeholder="Salaire min" value="{{ request('min_salary') }}"
                   class="input input-bordered w-full max-w-xs">
            <select name="type" class="select select-bordered w-full max-w-xs">
                <option value="">Type</option>
                <option value="CDI" {{ request('type') == 'CDI' ? 'selected' : '' }}>CDI</option>
                <option value="CDD" {{ request('type') == 'CDD' ? 'selected' : '' }}>CDD</option>
                <option value="Stage" {{ request('type') == 'Stage' ? 'selected' : '' }}>Stage</option>
                <option value="Alternance" {{ request('type') == 'Alternance' ? 'selected' : '' }}>Alternance</option>
            </select>
            <input type="text" name="sector" placeholder="Secteur" value="{{ request('sector') }}"
                   class="input input-bordered w-full max-w-xs">
            <input type="text" name="company" placeholder="Entreprise" value="{{ request('company') }}"
                   class="input input-bordered w-full max-w-xs">
            <button type="submit" class="btn btn-primary w-full md:w-auto">Rechercher</button>
        </form>

        <div class="flex justify-between">
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">
                ← Retour
            </a>
            <a href="{{ route('pilot.offer.create') }}" class="btn btn-accent">
                + Ajouter une offre
            </a>
        </div>

        <!-- Version Mobile: Cartes -->
        <div class="md:hidden flex flex-col gap-4 mt-6">
            @foreach ($offers as $offer)
                <div class="bg-white shadow-md rounded-xl p-4 space-y-2">
                    <h2 class="text-lg font-semibold">{{ $offer->title }}</h2>
                    <p class="text-gray-600">{{ Str::limit($offer->description, 80) }}</p>
                    <p class="text-gray-600">Salaire : {{ $offer->base_salary ?? 'Non précisé' }}</p>
                    <p class="text-gray-600">Type : {{ $offer->type }}</p>
                    <p class="text-gray-600">Entreprise : {{ $offer->companies->name ?? 'Non spécifié' }}</p>
                    <p class="text-gray-600">Secteur : {{ $offer->sector->name ?? 'Non spécifié' }}</p>
                    <div class="flex justify-between items-center mt-3">
                        <a href="{{ route('pilot.offer.edit', $offer) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <button class="btn btn-error btn-sm"
                                onclick="document.getElementById('modal-{{ $offer->id }}').showModal()">
                            Retirer
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Version Desktop: Tableau -->
        <div class="hidden md:block overflow-x-auto mt-6">
            <table class="table w-full bg-white shadow-md rounded-xl">
                <thead>
                <tr class="bg-gray-100">
                    <th class="text-center">Titre</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Salaire</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Entreprise</th>
                    <th class="text-center">Secteur</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($offers as $offer)
                    <tr class="hover:bg-gray-50">
                        <td class="text-center">{{ $offer->title }}</td>
                        <td class="text-center">{{ Str::limit($offer->description, 80) }}</td>
                        <td class="text-center">{{ $offer->base_salary ?? 'Non précisé' }}</td>
                        <td class="text-center">{{ $offer->type }}</td>
                        <td class="text-center">{{ $offer->companies->name ?? 'Non spécifié' }}</td>
                        <td class="text-center">{{ $offer->sector->name ?? 'Non spécifié' }}</td>
                        <td class="text-center flex justify-center gap-2 py-2">
                            <a href="{{ route('pilot.offer.edit', $offer) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <button class="btn btn-error btn-sm"
                                    onclick="document.getElementById('modal-{{ $offer->id }}').showModal()">
                                Retirer
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $offers->links() }}
        </div>

        <!-- Modaux de suppression -->
        @foreach ($offers as $offer)
            <dialog id="modal-{{ $offer->id }}" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                    <p class="py-4">
                        Êtes-vous sûr de vouloir supprimer l'offre
                        <strong>{{ $offer->title }}</strong> ?
                    </p>
                    <div class="modal-action flex justify-between">
                        <form method="dialog">
                            <button class="btn">Annuler</button>
                        </form>
                        <form action="{{ route('pilot.offer.destroy', $offer) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-error">Confirmer</button>
                        </form>
                    </div>
                </div>
                <form method="dialog" class="modal-backdrop">
                    <button class="cursor-default">Fermer</button>
                </form>
            </dialog>
        @endforeach
    </div>
@endsection
