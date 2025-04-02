@extends('layouts.app')

@section('title', 'Offres d\'emploi')

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

    <h1 class="text-lg md:text-4xl font-bold mb-6 text-center">Les Offres d'Emploi</h1>

    @foreach($offers as $offer)
        <!-- Modal de confirmation -->
        <dialog id="modal-{{ $offer->id }}" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                <p class="py-4">
                    Êtes-vous sûr de vouloir supprimer l'offre
                    <strong>{{ $offer->title }}</strong> ?
                </p>
                <div class="modal-action">
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

            <!-- Ce backdrop ferme le modal si on clique à l'extérieur -->
            <form method="dialog" class="modal-backdrop">
                <button class="cursor-default">Fermer</button>
            </form>
        </dialog>
    @endforeach

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('pilot.offer.index') }}" class="mb-6 flex flex-wrap gap-4 justify-center">
            <input type="text" name="title" placeholder="Titre" value="{{ request('title') }}" class="input input-bordered">
            <input type="number" name="min_salary" placeholder="Salaire min" value="{{ request('min_salary') }}" class="input input-bordered">
            <select name="type" class="select select-bordered">
                <option value="">Type</option>
                <option value="CDI" {{ request('type') == 'CDI' ? 'selected' : '' }}>CDI</option>
                <option value="CDD" {{ request('type') == 'CDD' ? 'selected' : '' }}>CDD</option>
                <option value="Stage" {{ request('type') == 'Stage' ? 'selected' : '' }}>Stage</option>
                <option value="Alternance" {{ request('type') == 'Alternance' ? 'selected' : '' }}>Alternance</option>
            </select>
            <input type="text" name="sector" placeholder="Secteur" value="{{ request('sector') }}" class="input input-bordered">
            <input type="text" name="company" placeholder="Company" value="{{ request('company') }}" class="input input-bordered">

            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>

        <div class="flex justify-between mb-6">
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary px-6 py-2 flex items-center ml-5">
                ← Retour
            </a>

            <a href="{{ route('pilot.offer.create') }}"
               class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
                Ajouter une offre
            </a>
        </div>

    <div class="md:hidden flex flex-col gap-4">
        @foreach ($offers as $offer)
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold">{{ $offer->title }}</h2>
                <p class="text-gray-600">{{ Str::limit($offer->description, 80) }}</p>
                <p class="text-gray-600">{{ $offer->base_salary ?? 'Non précisé' }}</p>
                <p class="text-gray-600">{{ $offer->type }}</p>
                <p class="text-gray-600">{{ $offer->companies->name ?? 'Non spécifié' }}</p>
                <p class="text-gray-600">{{ $offer->sector->name ?? 'Non spécifié' }}</p>
                <!-- Actions -->
                <div class="mt-3 flex justify-between">
                    <a href="{{ route('pilot.offer.edit', $offer) }}"
                       class="btn btn-secondary btn-sm">Modifier</a>
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
                <th class="border px-4 py-2 text-center text-lg">Titre</th>
                <th class="border px-4 py-2 text-center text-lg">Description</th>
                <th class="border px-4 py-2 text-center text-lg">Salaire</th>
                <th class="border px-4 py-2 text-center text-lg">Type</th>
                <th class="border px-4 py-2 text-center text-lg">Entreprise</th>
                <th class="border px-4 py-2 text-center text-lg">Secteur</th>
                <th class="border px-4 py-2 text-center text-lg">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($offers as $offer)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $offer->title }}</td>
                    <td class="border px-4 py-2">{{ Str::limit($offer->description, 80) }}</td>
                    <td class="border px-4 py-2">{{ $offer->base_salary ?? 'Non précisé' }}</td>
                    <td class="border px-4 py-2">{{ $offer->type }}</td>
                    <td class="border px-4 py-2">{{ $offer->companies->name ?? 'Non spécifié' }}</td>
                    <td class="border px-4 py-2">{{ $offer->sector->name ?? 'Non spécifié' }}</td>
                    <td class="border px-4 py-2 flex gap-2 justify-center">
                        <a href="{{ route('pilot.offer.edit', $offer) }}" class="btn btn-sm btn-primary">Modifier</a>
                        <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $offer->id }}').showModal()">
                            Retirer
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $offers->links() }}
    </div>
    </div>
@endsection
