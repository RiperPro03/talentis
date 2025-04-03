@extends('layouts.app')

@section('title', 'Créer un secteur d\'activité')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg mt-10 space-y-6">

        <h2 class="text-3xl font-bold text-center mb-6">Créer un secteur d'activité</h2>

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

        <form action="{{ route('industry.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="form-control w-full">
                <label class="label font-medium">Nom de l'industrie</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="Ex : Informatique, BTP, Finance..."
                       class="input input-bordered w-full">
                @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('industry.index') }}" class="btn btn-secondary">← Retour</a>
                <button type="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>
@endsection
