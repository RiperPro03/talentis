@extends('layouts.app')

@section('title', 'Gestion adresses - Talentis')

@section('content')
    <div class="container mx-auto py-8 px-4 space-y-6">

        @if (session('success'))
            <div class="alert alert-success shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error shadow-lg">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <ul class="ml-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <h1 class="text-3xl font-bold text-center">Liste des adresses</h1>

        {{-- Filtres --}}
        <form action="{{ route('address.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 justify-center mt-6">
            <input type="text" name="city" placeholder="Ville" value="{{ request('city') }}"
                   class="input input-bordered w-full md:max-w-xs">
            <input type="text" name="postal_code" placeholder="Code postal" value="{{ request('postal_code') }}"
                   class="input input-bordered w-full md:max-w-xs">
            <button type="submit" class="btn btn-primary w-full md:w-auto">Rechercher</button>
        </form>

        <div class="flex justify-between">
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">
                ← Retour
            </a>
            <a href="{{ route('address.create') }}" class="btn btn-accent">
                + Ajouter une offre
            </a>
        </div>

        {{-- Version Mobile --}}
        <div class="md:hidden flex flex-col gap-4">
            @foreach ($addresses as $address)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h2 class="text-lg font-semibold">{{ $address->city }}</h2>
                    <p class="text-gray-600">{{ $address->postal_code }}</p>

                    <div class="mt-3 flex justify-between">
                        <a href="{{ route('address.edit', $address->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $address->id }}').showModal()">
                            Retirer
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Version Desktop --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="table w-full border-collapse border bg-white text-sm md:text-base">
                <thead>
                <tr class="bg-gray-50">
                    <th class="border px-4 py-2 text-center">Ville</th>
                    <th class="border px-4 py-2 text-center">Code Postal</th>
                    <th class="border px-4 py-2 text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($addresses as $address)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $address->city }}</td>
                        <td class="border px-4 py-2 text-center">{{ $address->postal_code }}</td>
                        <td class="border px-4 py-2 flex gap-2 justify-center">
                            <a href="{{ route('address.edit', $address->id) }}" class="btn btn-warning btn-sm">
                                Modifier
                            </a>
                            <button class="btn btn-error btn-sm"
                                    onclick="document.getElementById('modal-{{ $address->id }}').showModal()">
                                Retirer
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $addresses->links() }}
        </div>

        {{-- Modaux --}}
        @foreach ($addresses as $address)
            <dialog id="modal-{{ $address->id }}" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                    <p class="py-4">Êtes-vous sûr de vouloir retirer l'adresse <strong>{{ $address->city }}</strong> ({{ $address->postal_code }}) ?</p>
                    <div class="modal-action flex justify-between">
                        <form method="dialog">
                            <button class="btn">Annuler</button>
                        </form>
                        <form action="{{ route('address.destroy', $address) }}" method="POST">
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
