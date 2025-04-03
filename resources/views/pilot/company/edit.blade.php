@extends('layouts.app')

@section('title', 'Modifier Entreprise')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-xl mt-10 space-y-6">

        <h2 class="text-3xl font-bold text-center mb-6">Modifier l'entreprise</h2>

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

        <form action="{{ route('pilot.company.update', $company) }}" method="POST" enctype="multipart/form-data"
              class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="label font-medium">Nom</label>
                    <input type="text" name="name" value="{{ old('name', $company->name) }}" class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email', $company->email) }}" class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Numéro de téléphone</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $company->phone_number) }}"
                           class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Secteur d'activité</label>
                    <select name="industry_id" class="select select-bordered w-full">
                        <option value="">-- Sélectionner --</option>
                        @foreach ($industries as $industry)
                            <option value="{{ $industry->id }}" {{ old('industry_id', $company->industries->first()->id ?? '') == $industry->id ? 'selected' : '' }}>
                                {{ $industry->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label font-medium">Code Postal</label>
                    <input type="text" name="postal_code"
                           value="{{ old('postal_code', $company->addresses->first()->postal_code ?? '') }}"
                           class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Ville</label>
                    <input type="text" name="city"
                           value="{{ old('city', $company->addresses->first()->city ?? '') }}"
                           class="input input-bordered w-full">
                </div>
            </div>

            <div>
                <label class="label font-medium">Description</label>
                <textarea name="description" rows="4" class="textarea textarea-bordered w-full">{{ old('description', $company->description) }}</textarea>
            </div>

            <div>
                <label class="label font-medium">Logo de l'entreprise</label>
                <input type="file" name="logo" accept="image/*"
                       class="file-input file-input-bordered w-full">
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('pilot.company.index') }}" class="btn btn-secondary">
                    ← Retour
                </a>
                <button type="submit" class="btn btn-primary">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
@endsection
