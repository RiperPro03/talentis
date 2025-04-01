@extends('layouts.app')

@section('title', 'Créer une Entreprise')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Créer une entreprise</h2>

        @if (session('success'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Nom</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Description</label>
                <textarea name="description" class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Numéro de Téléphone</label>
                <input type="text" name="phone_number" value="{{ old('phone_number') }}" 
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500"
                    pattern="^\+?[0-9]{10,15}$" title="Veuillez entrer un numéro valide (10 à 15 chiffres, avec ou sans +)">
                @error('phone_number') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Logo de l'entreprise</label>
                <input type="file" name="logo" accept="image/*"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('logo')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Créer</button>
            </div>
        </form>
    </div>
@endsection
