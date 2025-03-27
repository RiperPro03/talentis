@extends('layouts.app')

@section('title', 'Wish-list d\'Offres')

@section('content')
    <div class="container mx-auto py-6 px-4">
        {{--        <!-- Bouton de retour -->--}}
        {{--        <div class="flex justify-start mb-4">--}}
        {{--            <a href="{{ url()->previous() }}" class="btn btn-secondary">← Retour</a>--}}
        {{--        </div>--}}

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

                    <form action="{{ route('users.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-error btn-sm" onclick="console.log('Bouton cliqué');">Retirer</button>

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
                        <label for="modal_{{ $student->id }}" class="btn">open modal</label>

                        <!-- Input caché pour contrôler l'état du modal -->
                        <input type="checkbox" id="modal_{{ $student->id }}" class="modal-toggle" />

                        <dialog id="modal_{{ $student->id }}" class="modal">
                            <div class="modal-box">
                                <h3 class="text-lg font-bold">Hello, {{ $student->name }}!</h3>
                                <p class="py-4">Press ESC key or click outside to close</p>
                                <!-- Bouton de fermeture -->
                                <label for="modal_{{ $student->id }}" class="btn btn-secondary">Close</label>
                            </div>
                            <form method="dialog" class="modal-backdrop">
                                <button>close</button>
                            </form>
                        </dialog>
                    </td>


                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


@endsection
