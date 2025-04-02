@extends('layouts.app')

@section('title', 'Entreprises')

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

        <h1 class="text-lg md:text-4xl font-bold mb-6 text-center">Les entreprises</h1>
            @foreach($companies as $company)
                <!-- Modal de confirmation -->
                <dialog id="modal-{{ $company->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                        <p class="py-4">
                            Êtes-vous sûr de vouloir la companie
                            <strong>{{ $company->name }}</strong> ?
                        </p>
                        <div class="modal-action">
                            <form method="dialog">
                                <button class="btn">Annuler</button>
                            </form>
                            <form action="{{ route('pilot.company.destroy', $company) }}" method="POST">
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


            <form method="GET" action="{{ route('pilot.company.index') }}" class="mb-6 flex justify-center">
                <input type="text" name="name" placeholder="Rechercher par nom" value="{{ request('name') }}" class="input input-bordered w-full max-w-xs">
                <button type="submit" class="btn btn-primary ml-2">Rechercher</button>
            </form>

        <!-- Bouton Ajouter une entreprise placé sous le titre -->
        <div class="flex justify-between mb-6">
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary px-6 py-2 flex items-center ml-5">
                ← Retour
            </a>

            <a href="{{ route('pilot.company.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
                Ajouter une entreprise
            </a>
        </div>

        <!-- Version Mobile: Affichage en cartes -->

    <div class="md:hidden flex flex-col gap-4">
        @foreach ($companies as $company)
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold">{{ $company->name }}</h2>
                <p class="text-gray-600">{{ Str::limit($company->description, 80) }}</p>
                <p class="text-gray-600">{{ $company->email }}</p>
                <p class="text-gray-600">{{ $company->phone_number }}</p>
                <!-- Actions -->
                <div class="mt-3 flex justify-between">
                    <a href="{{ route('pilot.company.edit', $company) }}"
                       class="btn btn-secondary btn-sm">Modifier</a>
                    <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $company->id }}').showModal()">
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
                    <th class="border px-4 py-2 text-center text-lg">Nom</th>
                    <th class="border px-4 py-2 text-center text-lg">Description</th>
                    <th class="border px-4 py-2 text-center text-lg">Mail</th>
                    <th class="border px-4 py-2 text-center text-lg">Numéro de Téléphone</th>
                    <th class="border px-4 py-2 text-center text-lg">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $company->name }}</td>
                        <td class="border px-4 py-2">{{ Str::limit($company->description, 80) }}</td>
                        <td class="border px-4 py-2">{{ $company->email }}</td>
                        <td class="border px-4 py-2">{{ $company->phone_number }}</td>
                        <td class="border px-4 py-2">
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('pilot.company.edit', $company) }}"
                                    class="btn btn-secondary btn-sm">Modifier</a>
                                <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $company->id }}').showModal()">
                                    Retirer
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $companies->links() }}
    </div>
    </div>
@endsection
