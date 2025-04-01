@extends('layouts.app')

@section('title', 'Créer un skill')

@section('content')

        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-10">
            <h2 class="text-2xl font-bold mb-6">Créer un skill</h2>

            @if (session('success'))
                <div class="bg-green-500 text-white p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('skill.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block font-medium"> Nom du skill </label>
                    <input type="text" name="name" placeholder="Nom du skill"  class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                    @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Créer</button>
                </div>
            </form>
        </div>

    <a href="{{ route('skill.index') }}" class="btn btn-secondary w-fit mx-auto mt-4 px-6 py-2 flex items-center justify-center">
        ← Retour
    </a>

@endsection
