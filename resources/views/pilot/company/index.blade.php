@extends('layouts.app')

@section('title', 'Gestion entreprises - Talentis')

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

        <h1 class="text-3xl font-bold text-center mb-6">Gestion des entreprises</h1>

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('pilot.company.index') }}"
              class="flex flex-col md:flex-row gap-4 justify-center items-center mb-8">
            <input type="text" name="name" placeholder="Rechercher par nom" value="{{ request('name') }}"
                   class="input input-bordered w-full max-w-xs">
            <button type="submit" class="btn btn-primary w-full md:w-auto">Rechercher</button>
        </form>

        <div class="flex justify-between">
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">
                ← Retour
            </a>
            <a href="{{ route('pilot.company.create') }}" class="btn btn-accent">
                + Ajouter une entreprise
            </a>
        </div>

        <!-- Version Mobile: Cartes -->
        <div class="md:hidden flex flex-col gap-4 mt-6">
            @foreach ($companies as $company)
                <div class="bg-white shadow-md rounded-xl p-4 space-y-2">
                    <h2 class="text-lg font-semibold">{{ $company->name }}</h2>
                    <p class="text-gray-600">{{ Str::limit($company->description, 80) }}</p>
                    <p class="text-gray-600">{{ $company->email }}</p>
                    <p class="text-gray-600">{{ $company->phone_number }}</p>
                    <div class="flex justify-between items-center mt-3">
                        <a href="{{ route('pilot.company.edit', $company) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <button class="btn btn-error btn-sm"
                                onclick="document.getElementById('modal-{{ $company->id }}').showModal()">
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
                    <th class="border px-4 py-2 text-center">Nom</th>
                    <th class="border px-4 py-2 text-center">Description</th>
                    <th class="border px-4 py-2 text-center">Email</th>
                    <th class="border px-4 py-2 text-center">Téléphone</th>
                    <th class="border px-4 py-2 text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($companies as $company)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $company->name }}</td>
                        <td class="border px-4 py-2 text-center">{{ Str::limit($company->description, 80) }}</td>
                        <td class="border px-4 py-2 text-center">{{ $company->email }}</td>
                        <td class="border px-4 py-2 text-center">{{ $company->phone_number }}</td>
                        <td class="border px-4 py-2 text-center flex justify-center gap-2 py-2">
                            <a href="{{ route('pilot.company.edit', $company) }}"
                               class="btn btn-warning btn-sm">Modifier</a>
                            <button class="btn btn-error btn-sm"
                                    onclick="document.getElementById('modal-{{ $company->id }}').showModal()">
                                Retirer
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $companies->links() }}
        </div>

        <!-- Modaux de suppression -->
        @foreach ($companies as $company)
            <dialog id="modal-{{ $company->id }}" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                    <p class="py-4">
                        Êtes-vous sûr de vouloir supprimer l'entreprise
                        <strong>{{ $company->name }}</strong> ?
                    </p>
                    <div class="modal-action flex justify-between">
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
                <form method="dialog" class="modal-backdrop">
                    <button class="cursor-default">Fermer</button>
                </form>
            </dialog>
        @endforeach
    </div>
@endsection
