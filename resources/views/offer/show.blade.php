@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center min-h-[80vh] p-6">
        <div class="card w-full max-w-lg bg-base-100 shadow-xl p-6 rounded-2xl flex flex-col h-full">
            <a href="{{ route('offer.index') }}" class="absolute top-4 left-4 btn btn-outline btn-primary">
                ← Retour
            </a>

            <!-- Logo de l'entreprise -->
            <div class="flex justify-center mb-4">
                <img src="{{ asset($offer->companies->logo_path) }}" alt="{{ 'logo_' . $offer->companies->name }}"
                    class="h-20 w-20 object-contain">
            </div>

            <!-- Nom de l'entreprise avec lien -->
            <div class="text-center mb-4">
                <a href="{{ route('company.show', $offer->companies->id) }}"
                    class="text-xl font-bold text-primary hover:underline">
                    {{ $offer->companies->name }}
                </a>
            </div>

            <!-- Informations supplémentaires sur l'entreprise -->
            <div class="text-center text-gray-700 text-base space-y-2 mb-6">
                <p>
                    📧 <a href="mailto:{{ $offer->companies->email }}" class="text-blue-600 hover:underline">
                        {{ $offer->companies->email }}
                    </a>
                </p>
                <p>
                    📞 <span class="font-semibold">{{ $offer->companies->phone_number }}</span>
                </p>
                <p>
                    📍 <span class="font-semibold">
                        {{ $offer->companies->addresses->first()->postal_code }}
                        {{ $offer->companies->addresses->first()->city }}
                    </span>
                </p>
            </div>

            <!-- Contenu principal -->
            <div class="text-center flex-1 flex flex-col justify-center space-y-3">
                <h1 class="text-3xl font-extrabold text-gray-900">{{ $offer->title }}</h1>
                <p class="text-lg text-gray-600 font-medium">{{ $offer->type }}</p>
                <p class="text-base text-gray-700">{{ $offer->description }}</p>

                <div class="flex flex-col items-center gap-2 text-lg">
                    <p class="font-semibold flex items-center gap-2">
                        💰 Salaire : <span class="text-primary">{{ number_format($offer->base_salary, 0, ',', ' ') }}
                            €</span>
                    </p>
                    <p class="font-semibold flex items-center gap-2">
                        📅 Début : <span>{{ \Carbon\Carbon::parse($offer->start_offer)->format('d/m/Y') }}</span>
                    </p>
                </div>
            </div>

            <!-- Badges Industry / Sector / Skills -->
            <div class="flex flex-wrap justify-center gap-2 mt-5">
                @if ($offer->companies->industries->isNotEmpty())
                    @foreach ($offer->companies->industries as $industry)
                        <span class="badge bg-blue-600 text-white px-3 py-1 text-sm rounded-full">
                            {{ $industry->name }}
                        </span>
                    @endforeach
                @endif

                @if ($offer->sector)
                    <span class="badge bg-green-600 text-white px-3 py-1 text-sm rounded-full">
                        {{ $offer->sector->name }}
                    </span>
                @endif

                @foreach ($offer->skills as $skill)
                    <span class="badge bg-purple-600 text-white px-3 py-1 text-sm rounded-full">
                        {{ $skill->skill_name }}
                    </span>
                @endforeach
            </div>

            <!-- Nombre de candidats ayant postulé -->
            <div class="text-center text-gray-700 mt-5 text-base font-semibold">
                📩 Nombre de candidatures : <span class="text-primary">{{ $offer->applies->count() }}</span>
            </div>

            <!-- Bouton Postuler -->
            <div class="card-actions mt-6">
                <a href="#" class="btn btn-primary w-full text-lg py-3 flex items-center justify-center">
                    Postuler
                </a>
            </div>
        </div>
    </div>
@endsection
