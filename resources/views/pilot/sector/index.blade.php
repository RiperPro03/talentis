@extends('layouts.app')

@section('title', 'Index des secteurs')

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

        <h1 class="text-lg md:text-4xl font-bold mb-6 text-center">Les secteurs</h1>

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('sector.index') }}" class="mb-6">
            <div class="flex gap-2">
                <input type="text" name="name" placeholder="Rechercher un secteur" value="{{ request('name') }}"
                       class="input input-bordered w-full max-w-xs">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>

        <div class="hidden md:block overflow-x-auto">
            <table class="table w-full border-collapse border bg-white text-sm md:text-base">
                <thead>
                <tr class="bg-gray-50">
                    <th class="border px-4 py-2 text-center text-lg">Secteur</th>
                    <th class="border px-4 py-2 text-center text-lg">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($sectors as $sector)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $sector->name }}</td>
                        <td class="border px-4 py-2 flex gap-2 justify-center">
                            <a href="{{ route('sector.edit', $sector->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                            <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $sector->id }}').showModal()">Retirer</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-between mt-4">
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary px-6 py-2 flex items-center ml-5">← Retour</a>
            <a href="{{ route('sector.create') }}" class="btn btn-secondary px-6 py-2 flex items-center mr-5">Ajouter un secteur</a>
        </div>
    </div>
@endsection
