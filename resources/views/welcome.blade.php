@extends('layouts.app')

@section('title', 'Accueil - Talentis')

@section('content')

    <div class="text-center space-y-4">
        <h1 class="mt-4 animate-gradient-text text-6xl md:text-9xl font-bold bg-clip-text text-transparent
                        bg-gradient-to-r from-primary via-secondary to-accent
                        bg-[length:200%_auto] md:bg-[length:250%_auto]
                        transition-all duration-1000">
            Talentis
        </h1>

        <h2 class="text-2xl md:text-4xl font-light opacity-0 animate-fade-in-up delay-300">
            Trouvez de nouvelles opportunités !
        </h2>
    </div>

    <!-- SEARCH BAR -->
    <form action="{{ route('offer.index') }}" method="GET"
          class="flex flex-col md:flex-row items-center justify-center gap-2 md:gap-4 bg-white p-6 shadow-lg rounded-lg w-full max-w-4xl mx-auto mt-4">

        <!-- Input: titre de l'offre -->
        <input type="text" name="offer-title" placeholder="Vous cherchez ?"
               class="input input-bordered w-full md:w-1/4"/>

        <!-- Input: localisation -->
        <select name="location[]" class="select select-bordered w-full md:w-1/4">
            <option disabled {{ empty(request('type')) ? 'selected' : '' }}>Où ?</option>
            @foreach($locations as $location)
                <option value="{{ $location->city }}">
                    {{ $location->city }}
                </option>
            @endforeach
        </select>

        <!-- Select: Type d'emploi -->
        <select name="type[]" class="select select-bordered w-full md:w-1/4">
            <option disabled {{ empty(request('type')) ? 'selected' : '' }}>Type d'emploi</option>
            @foreach(['CDI', 'CDD', 'Stage', 'Alternance'] as $type)
                <option value="{{ $type }}">
                    {{ $type }}
                </option>
            @endforeach
        </select>

        <!-- Bouton de recherche -->
        <button type="submit" class="btn btn-primary text-white w-full md:w-auto">
            Rechercher
        </button>
    </form>




    <div class="relative w-full max-w-6xl mx-auto mt-6">
        <div class="carousel-wrapper">
            <div class="carousel flex gap-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory px-4 scroll-smooth">
                @foreach($offers as $offer)
                    <div class="carousel-item w-80 snap-center shrink-0">
                        <div class="card bg-base-100 shadow-xl min-h-[360px] w-full flex flex-col justify-between">
                            @if($offer->companies && $offer->companies->logo_path)
                                <figure class="px-6 pt-6">
                                    <img src="{{ Storage::url($offer->companies->logo_path) }}"
                                         alt="{{ 'logo_' . $offer->companies->name }}"
                                         class="rounded-xl w-auto h-24 object-contain" />
                                </figure>
                            @endif

                            <div class="card-body flex flex-col items-center text-center justify-between flex-1">
                                <h2 class="card-title">{{ $offer->title }}</h2>
                                <p class="text-sm text-gray-600">{{ Str::limit($offer->description, 80) }}</p>

                                <div class="card-actions mt-auto">
                                    <a href="{{ route('offer.show', $offer) }}" class="btn btn-primary">En savoir plus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-prev hidden lg:flex absolute left-0 top-1/2 btn btn-circle btn-primary ">❮</button>
            <button class="carousel-next hidden lg:flex absolute right-0 top-1/2 btn btn-circle btn-primary">❯</button>
        </div>
    </div>
@endsection
