@extends('layouts.app')

@section('title', 'Index des addresses')

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


        <h1 class="text-lg md:text-4xl font-bold mb-6 text-center">Les addresses</h1>
        @foreach($addresses as $address)
            <dialog id="modal-{{ $address->id }}" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                    <p class="py-4">
                        Êtes-vous sûr de vouloir retirer {{ $address->city }} dans le {{ $address->postal_code }} ?
                    </p>
                    <div class="modal-action flex justify-between">
                        <form action="{{ route('address.destroy', $address) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-error">Confirmer</button>
                        </form>
                        <form method="dialog">
                            <button class="btn">Annuler</button>
                        </form>
                    </div>
                </div>

                <!-- Ce backdrop ferme le modal si on clique à l'extérieur -->
                <form method="dialog" class="modal-backdrop">
                    <button class="cursor-default">Fermer</button>
                </form>
            </dialog>
        @endforeach


        <!-- Version Mobile: Affichage en cartes -->
    </div>


    <div class="md:hidden flex flex-col gap-4">
        @foreach ($addresses as $address)
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold">{{ $address->city }}</h2>
                <p class="text-gray-600">{{ $address->postal_code }}</p>

                <!-- Actions -->
                <div class="mt-3 flex justify-between">
                    <a href="{{ route('address.edit', $address->id) }}" class="btn btn-primary btn-sm">
                        Modifier
                    </a>

                    <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $address->id }}').showModal()">
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
                <th class="border px-4 py-2 text-center text-lg">Ville</th>
                <th class="border px-4 py-2 text-center text-lg">Code Postal</th>
                <th class="border px-4 py-2 text-center text-lg">Actions</th>
            </tr>
            </thead>
            <tbody>

            @foreach($addresses as $address)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $address->city}}</td>
                    <td class="border px-4 py-2">{{ $address->postal_code}}</td>

                    <td class="border px-4 py-2 flex gap-2 justify-center">
                        <a href="{{ route('address.edit', $address->id) }}" class="btn btn-primary btn-sm">
                            Modifier
                        </a>

                        <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $address->id }}').showModal()">
                            Retirer
                        </button>



                    </td>


                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex justify-between mt-4">

    <a href="{{route('dashboard.index')}}" class="btn btn-secondary px-6 py-2 flex items-center ml-5">
        ← Retour
    </a>
    <a href="{{ route('address.create') }}" class="btn btn-secondary px-6 py-2 flex items-center mr-5">
        Ajouter une address
    </a>
    </div>
@endsection
