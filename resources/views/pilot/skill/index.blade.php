@extends('layouts.app')

@section('title', 'Index des skills')

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
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <h1 class="text-lg md:text-4xl font-bold mb-6 text-center">Les skills</h1>

        <!-- Champ de recherche -->
        <form method="GET" action="{{ route('skill.index') }}" class="mb-6">
            <input type="text" name="search" placeholder="Rechercher un skill..."
                   value="{{ request('search') }}" class="input input-bordered w-full max-w-md" />
            <button type="submit" class="btn btn-primary ml-2">Rechercher</button>
        </form>

            <div class="flex justify-between mb-6">
                <a href="{{ route('dashboard.index') }}" class="btn btn-secondary px-6 py-2 flex items-center ml-5">
                    ← Retour
                </a>

                <a href="{{ route('skill.create') }}"
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600">
                    Ajouter une entreprise
                </a>
            </div>

        @foreach ($skills as $skill)
            <dialog id="modal-{{ $skill->id }}" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                    <p class="py-4">Êtes-vous sûr de vouloir retirer {{ $skill->skill_name }} ?</p>
                    <div class="modal-action flex justify-between">
                        <form action="{{ route('skill.destroy', $skill) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-error">Confirmer</button>
                        </form>
                        <form method="dialog">
                            <button class="btn">Annuler</button>
                        </form>
                    </div>
                </div>
                <form method="dialog" class="modal-backdrop">
                    <button class="cursor-default">Fermer</button>
                </form>
            </dialog>
        @endforeach

            <div class="md:hidden flex flex-col gap-4">
                @foreach ($skills as $skill)
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h2 class="text-lg font-semibold">{{ $skill->skill_name }}</h2>
                        <!-- Actions -->
                        <div class="mt-3 flex justify-between">
                            <a href="{{ route('skill.edit', $skill) }}"
                               class="btn btn-secondary btn-sm">Modifier</a>
                            <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $skill->id }}').showModal()">
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
                    <th class="border px-4 py-2 text-center text-lg">Skill</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($skills as $skill)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $skill->skill_name }}</td>
                        <td class="border px-4 py-2 flex gap-2 justify-center">
                            <a href="{{ route('skill.edit', $skill->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                            <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $skill->id }}').showModal()">Retirer</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $skills->links() }}
    </div>
@endsection
