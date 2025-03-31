@extends('layouts.app')

@section('title', 'Modifier Entreprise')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Modifier l'entreprise</h2>

        @if (session('success'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('company.update', $company) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Nom</label>
                <input type="text" name="name" value="{{ old('name', $company->name) }}" class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Description</label>
                <textarea name="description" class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">{{ old('description', $company->description) }}</textarea>
                @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $company->email) }}" class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Numéro de Téléphone</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $company->phone_number) }}" class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('phone_number') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection
