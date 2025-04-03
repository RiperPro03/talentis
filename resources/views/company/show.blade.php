@extends('layouts.app')

@section('title', "Entreprise - Talentis")

@section('content')
    <div class="max-w-6xl mx-auto p-6">

        {{-- Logo + Nom --}}
        <div class="flex flex-col items-center justify-center text-center mb-10">
            <img src="{{ Storage::url($company->logo_path) }}" alt="Logo {{ $company->name }}"
                 class="w-32 h-32 rounded-full object-cover shadow-md mb-4">
            <h1 class="text-4xl font-bold text-gray-800">{{ $company->name }}</h1>
            <span class="text-sm text-gray-500 mt-2">
                @foreach($company->industries as $industry)
                    <span class="badge badge-outline text-xs">{{ $industry->name }}</span>
                @endforeach
            </span>
        </div>

        {{-- Statistique --}}
        <div class="grid md:grid-cols-3 gap-6 mb-10">
            <div class="stat bg-white shadow-md rounded-xl text-center">
                <div class="stat-title">Candidatures reçues</div>
                <div class="stat-value text-primary">{{ $appliesCount }}</div>
                <div class="stat-desc">utilisateur(s) ont postulé</div>
            </div>
            <div class="stat bg-white shadow-md rounded-xl text-center">
                <div class="stat-title">Note moyenne</div>
                <div class="stat-value">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="inline-block w-5 h-5 {{ $i <= $company->getRate() ? 'text-yellow-400' : 'text-gray-300' }}"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 3.012a1 1 0 011.902 0l1.342 3.767a1 1 0 00.95.69h3.993a1 1 0 01.592 1.81l-3.235 2.36a1 1 0 00-.364 1.118l1.236 3.784a1 1 0 01-1.54 1.118l-3.23-2.36a1 1 0 00-1.176 0l-3.23 2.36a1 1 0 01-1.54-1.118l1.236-3.784a1 1 0 00-.364-1.118l-3.235-2.36a1 1 0 01.592-1.81h3.993a1 1 0 00.95-.69l1.342-3.767z"/>
                        </svg>
                    @endfor
                </div>
                <div class="stat-desc">
                    @if($company->getRate() === 0)
                        Aucune note
                    @else
                        Moyenne sur 5
                    @endif
                </div>
            </div>
            <div class="stat bg-white shadow-md rounded-xl text-center">
                <div class="stat-title">Nombre d'offres</div>
                <div class="stat-value text-secondary">{{ $company->offers->count() }}</div>
                <div class="stat-desc">publiées par l’entreprise</div>
            </div>
        </div>

        {{-- Description + Lieux --}}
        <div class="bg-base-100 p-6 rounded-lg shadow-md mb-10">
            <h2 class="text-xl font-semibold mb-4">Présentation</h2>
            <p class="text-gray-700 leading-relaxed">{{ $company->description ?? 'Aucune description disponible.' }}</p>

            <h3 class="mt-6 font-medium text-gray-800">Présente à :</h3>
            <div class="flex flex-wrap gap-2 mt-2">
                @forelse($company->addresses as $location)
                    <div class="badge badge-xl badge-ghost whitespace-nowrap flex items-center">
                        <svg class="w-4 h-4 mr-1 inline-block" fill="none" stroke="red" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 11c1.326 0 2.4-.93 2.4-2.077S13.326 6.846 12 6.846s-2.4.93-2.4 2.077S10.674 11 12 11z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 22s8-6.33 8-11.23A8 8 0 104 10.77C4 15.67 12 22 12 22z">
                            </path>
                        </svg>
                        {{ $location->city }}
                    </div>
                @empty
                    <span class="text-sm text-gray-500">Aucune localisation renseignée.</span>
                @endforelse
            </div>
        </div>

        {{-- Notation --}}
        <div class="bg-white p-6 rounded-lg shadow mb-10">
            <h2 class="text-xl font-semibold mb-4">Votre avis compte !</h2>

            <form action="{{ route('company.rate', $company) }}" method="POST">
                @csrf
                @php
                    $existingRating = $company->evaluations->where('id', auth()->id())->first()?->pivot->rating;
                @endphp
                <div class="rating mb-4">
                    @for ($i = 1; $i <= 5; $i++)
                        <input type="radio" name="rating" class="mask mask-star-2 bg-orange-400"
                               value="{{ $i }}" {{ $existingRating == $i ? 'checked' : '' }}>
                    @endfor
                </div>
                <button type="submit" class="btn btn-primary">Noter</button>
            </form>
        </div>

        {{-- Dernières offres --}}
        <div class="mb-12">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">Dernières offres</h2>
                <a href="{{ route('offer.index', ['company' => [$company->name]]) }}" class="link link-primary text-sm">
                    Voir toutes les offres →
                </a>
            </div>

            @if($company->latestOffers()->isEmpty())
                <p class="text-gray-500">Aucune offre récente pour le moment.</p>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($company->latestOffers() as $offer)
                        <div class="card shadow-md bg-base-100 border">
                            <div class="card-body">
                                <h3 class="card-title text-primary">{{ $offer->title }}</h3>
                                <p class="text-sm text-gray-600">{{ Str::limit($offer->description, 80) }}</p>
                                <div class="flex flex-wrap gap-2 mt-3">
                                    <span class="badge badge-outline">{{ $offer->type }}</span>
                                    <span class="badge badge-success">{{ $offer->base_salary }}€</span>
                                    <span class="badge badge-info">{{ $offer->sector->name }}</span>
                                </div>
                                <div class="card-actions justify-end mt-4">
                                    <a href="{{ route('offer.show', $offer) }}" class="btn btn-sm btn-outline btn-primary">
                                        Détail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
