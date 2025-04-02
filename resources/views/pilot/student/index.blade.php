@extends('layouts.app')

@section('title', 'Liste d\'étudiants')

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


        <h1 class="text-lg md:text-4xl font-bold mb-6 text-center">Les étudiants</h1>

@foreach($students as $student)
            <dialog id="modal-{{ $student->id }}" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                    <p class="py-4">
                        Êtes-vous sûr de vouloir retirer {{ $student->first_name }} {{ $student->name }} ?
                    </p>
                    <div class="modal-action flex justify-between">
                        <form action="{{ route('student.destroy', $student) }}" method="POST">
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
        @foreach ($students as $student)
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold">{{ $student->name }}</h2>
                <p class="text-gray-600">{{ $student->first_name }}</p>
                <p class="text-gray-600">{{ $student->email }}</p>
                <!-- Actions -->
                <div class="mt-3 flex justify-between">
                    <a href="{{ route('student.edit', $student->id) }}" class="btn btn-primary btn-sm">
                        Modifier
                    </a>

                    <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $student->id }}').showModal()">
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
                <th class="border px-4 py-2 text-center text-lg">Prénom</th>
                <th class="border px-4 py-2 text-center text-lg">Mail</th>
                <th class="border px-4 py-2 text-center text-lg">Actions</th>
            </tr>
            </thead>
            <tbody>

            @foreach($students as $student)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $student->name }}</td>
                    <td class="border px-4 py-2">{{ $student->first_name }}</td>
                    <td class="border px-4 py-2">
                        {{$student->email}}
                    </td>
                    <td class="border px-4 py-2 flex gap-2 justify-center">
                        <a href="{{ route('student.edit', $student->id) }}" class="btn btn-primary btn-sm">
                            Modifier
                        </a>

                        <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $student->id }}').showModal()">
                            Retirer
                        </button>



                    </td>


                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex justify-between mt-4">
        <a href="{{ route('dashboard.index') }}" class="btn btn-secondary px-6 py-2 flex items-center ml-5">
            ← Retour
        </a>
        <a href="{{ route('student.create') }}" class="btn btn-secondary px-6 py-2 flex items-center mr-5">
            Ajouter un étudiant
        </a>
    </div>


@endsection
