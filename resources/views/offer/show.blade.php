@extends('layouts.app')

@section('title', 'Offre - ' . $offer->title . ' - Talentis')

@section('content')
    <div class="flex justify-center items-center min-h-[80vh] p-6">
        <div class="card w-full max-w-lg bg-base-100 shadow-xl p-6 rounded-2xl flex flex-col h-full">

            @if (session('success'))
                <div class="alert alert-success shadow-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error shadow-lg mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <a href="{{ route('offer.index') }}" class="absolute top-4 left-4 btn btn-outline btn-primary">
                ← Retour
            </a>

            {{-- Logo --}}
            @if (optional($offer->companies)->logo_path)
                <div class="flex justify-center mb-4">
                    <img src="{{ Storage::url($offer->companies->logo_path) }}"
                         alt="{{ 'logo_' . $offer->companies->name }}"
                         class="h-20 w-20 object-contain rounded-full shadow">
                </div>
            @endif

            {{-- Entreprise --}}
            @if ($offer->companies)
                <div class="text-center mb-4">
                    <a href="{{ route('company.show', $offer->companies->id) }}"
                       class="text-xl font-bold text-primary hover:underline">
                        {{ $offer->companies->name }}
                    </a>
                </div>

                <div class="text-center text-gray-700 text-base space-y-2 mb-6">
                    @if ($offer->companies->email)
                        <p>📧 <a href="mailto:{{ $offer->companies->email }}" class="text-blue-600 hover:underline">{{ $offer->companies->email }}</a></p>
                    @endif
                    @if ($offer->companies->phone_number)
                        <p>📞 <span class="font-semibold">{{ $offer->companies->phone_number }}</span></p>
                    @endif
                    @if ($offer->companies->addresses && $offer->companies->addresses->isNotEmpty())
                        <div class="flex flex-wrap justify-center gap-2 mt-2">
                            @foreach ($offer->companies->addresses as $location)
                                <div class="badge badge-ghost whitespace-nowrap">
                                    📍 {{ $location->city . ' ' . $location->postal_code }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            {{-- Contenu de l'offre --}}
            <div class="text-center flex-1 flex flex-col justify-center space-y-3">
                <h1 class="text-3xl font-extrabold text-gray-900">{{ $offer->title }}</h1>
                <p class="text-lg text-gray-600 font-medium">{{ $offer->type }}</p>
                <p class="text-base text-gray-700">{{ $offer->description }}</p>

                <div class="flex flex-col items-center gap-2 text-lg">
                    @if ($offer->base_salary)
                        <p class="font-semibold flex items-center gap-2">
                            💰 Salaire : <span class="text-primary">{{ number_format($offer->base_salary, 0, ',', ' ') }} €</span>
                        </p>
                    @endif
                    <p class="font-semibold flex items-center gap-2">
                        📅 Début : <span>{{ \Carbon\Carbon::parse($offer->start_offer)->format('d/m/Y') }}</span>
                    </p>
                </div>
            </div>

            {{-- Badges --}}
            <div class="flex flex-wrap justify-center gap-2 mt-5">
                @if ($offer->companies && $offer->companies->industries && $offer->companies->industries->isNotEmpty())
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

                @if ($offer->skills && $offer->skills->isNotEmpty())
                    @foreach ($offer->skills as $skill)
                        <span class="badge bg-purple-600 text-white px-3 py-1 text-sm rounded-full">
                            {{ $skill->skill_name }}
                        </span>
                    @endforeach
                @endif
            </div>

            <div class="text-center text-gray-700 mt-5 text-base font-semibold">
                📩 Nombre de candidatures : <span class="text-primary">{{ optional($offer->applies)->count() ?? 0 }}</span>
            </div>

            @if (!auth()->user()->hasRole('pilot'))
                <form action="{{ route('wishlist.store', $offer) }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                    <button type="submit"
                            class="btn btn-outline w-full text-lg py-3 flex items-center justify-center gap-2">
                        ❤️ Ajouter aux favoris
                    </button>
                </form>

                <div class="card-actions mt-6">
                    <a href="{{ route('apply.create', $offer) }}"
                       class="btn btn-primary w-full text-lg py-3 flex items-center justify-center">
                        Postuler
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
