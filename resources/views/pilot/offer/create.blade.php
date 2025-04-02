@extends('layouts.app')

@section('title', 'Créer une Offre')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Créer une Offre</h2>

        @if (session('success'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

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

        <form action="{{ route('offer.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Titre</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('title')
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
                <label class="block font-medium">Salaire de base</label>
                <input type="number" name="base_salary" value="{{ old('base_salary') }}"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('base_salary')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Type</label>
                <select name="type"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                    <option value="CDI" {{ old('type') == 'CDI' ? 'selected' : '' }}>CDI</option>
                    <option value="CDD" {{ old('type') == 'CDD' ? 'selected' : '' }}>CDD</option>
                    <option value="Stage" {{ old('type') == 'Stage' ? 'selected' : '' }}>Stage</option>
                    <option value="Alternance" {{ old('type') == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                </select>
                @error('type')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Date de début</label>
                <input type="date" name="start_offer" value="{{ old('start_offer') }}"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('start_offer')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Date de fin</label>
                <input type="date" name="end_offer" value="{{ old('end_offer') }}"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-medium">Entreprise</label>
                <select name="company_id"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                @error('company_id')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Secteur</label>
                <select name="sector_id"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                    @foreach ($sectors as $sector)
                        <option value="{{ $sector->id }}" {{ old('sector_id') == $sector->id ? 'selected' : '' }}>
                            {{ $sector->name }}
                        </option>
                    @endforeach
                </select>
                @error('sector_id')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Compétences</label>
                <x-multi-select-filter name="skills" label="Compétences" :items="$skills" key="skill_name" :default="implode(',', $skills->pluck('id')->toArray())"
                    :multiple="true" />
                @error('skills')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-between">
                <a href="{{ route('pilot.offer.index') }}" class="bg-red-300 text-gray-700 px-4 py-2 rounded-lg">&larr;
                    Retour</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Créer</button>
            </div>
        </form>
    </div>
@endsection
