@extends('layouts.app')

@section('title', 'Offres d\'emploi')

@section('content')
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

    <!-- Bouton Ajouter une offre -->
    <div class="flex justify-end mb-6">
        <a href="{{ route('offer.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
            Ajouter une offre
        </a>
    </div>

    <!-- Version Mobile: Affichage en cartes -->
    </div>

    <div class="md:hidden flex flex-col gap-4">
        @foreach ($offers as $offer)
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold">{{ $offer->title }}</h2>
                <p class="text-gray-600">{{ $offer->description }}</p>
                <p class="text-gray-600">Salaire: {{ $offer->base_salary ?? 'Non précisé' }}</p>
                <p class="text-gray-600">Type: {{ $offer->type }}</p>
                <p class="text-gray-600">Entreprise: {{ $offer->companies->name ?? 'Non spécifié' }}</p>
                <p class="text-gray-600">Secteur: {{ $offer->sector->name ?? 'Non spécifié' }}</p>
                <!-- Actions -->
                <div class="mt-3 flex justify-between">
                    <a href="{{ route('offer.show', $offer) }}" class="btn btn-primary btn-sm">Voir</a>
                    <form action="{{ route('offer.destroy', $offer) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-error btn-sm">Retirer</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Version Desktop: Affichage en tableau -->
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
                        <td class="border px-4 py-2">{{ $offer->description }}</td>
                        <td class="border px-4 py-2">{{ $offer->base_salary ?? 'Non précisé' }}</td>
                        <td class="border px-4 py-2">{{ $offer->type }}</td>
                        <td class="border px-4 py-2">{{ $offer->companies->name ?? 'Non spécifié' }}</td>
                        <td class="border px-4 py-2">{{ $offer->sector->name ?? 'Non spécifié' }}</td>
                        <td class="border px-4 py-2 flex gap-2 justify-center">
                            <a href="{{ route('offer.edit', $offer) }}" class="btn btn-sm btn-primary">Modifier</a>
                            <form action="{{ route('offer.destroy', $offer) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-error">Retirer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $offers->links() }}
    </div>
@endsection
