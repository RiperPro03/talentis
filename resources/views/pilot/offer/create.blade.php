@extends('layouts.app')

@section('title', 'Créer une Offre')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-xl mt-10 space-y-6">

        <h2 class="text-3xl font-bold text-center mb-6">Créer une offre d'emploi</h2>

        @if (session('success'))
            <div class="alert alert-success shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 w-6 h-6" fill="none"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m-6 4V9m0 12A9 9 0 1 0 3 12a9 9 0 0 0 18 0 9 9 0 0 0-18 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error shadow-lg">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 w-6 h-6" fill="none"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <ul class="ml-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('pilot.offer.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="label font-medium">Titre</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Type</label>
                    <select name="type" class="select select-bordered w-full">
                        <option value="">-- Sélectionner --</option>
                        <option value="CDI" {{ old('type') == 'CDI' ? 'selected' : '' }}>CDI</option>
                        <option value="CDD" {{ old('type') == 'CDD' ? 'selected' : '' }}>CDD</option>
                        <option value="Stage" {{ old('type') == 'Stage' ? 'selected' : '' }}>Stage</option>
                        <option value="Alternance" {{ old('type') == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                    </select>
                </div>

                <div>
                    <label class="label font-medium">Salaire de base</label>
                    <input type="number" name="base_salary" value="{{ old('base_salary') }}"
                           class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Date de début</label>
                    <input type="date" name="start_offer" value="{{ old('start_offer') }}"
                           class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Date de fin</label>
                    <input type="date" name="end_offer" value="{{ old('end_offer') }}"
                           class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Entreprise</label>
                    <select name="company_id" class="select select-bordered w-full">
                        <option value="">-- Sélectionner --</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label font-medium">Secteur</label>
                    <select name="sector_id" class="select select-bordered w-full">
                        <option value="">-- Sélectionner --</option>
                        @foreach ($sectors as $sector)
                            <option value="{{ $sector->id }}" {{ old('sector_id') == $sector->id ? 'selected' : '' }}>
                                {{ $sector->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="label font-medium">Description</label>
                <textarea name="description" rows="4" class="textarea textarea-bordered w-full">{{ old('description') }}</textarea>
            </div>

            <div>
                <x-multi-select-filter name="skills" label="Compétences" :items="$skills" key="skill_name"/>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('pilot.offer.index') }}" class="btn btn-secondary">
                    ← Retour
                </a>
                <button type="submit" class="btn btn-primary">
                    Créer
                </button>
            </div>
        </form>
    </div>
@endsection
