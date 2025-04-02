@extends('layouts.app')

@section('title', 'Offres - Talentis')

@section('content')
    <div class="mx-auto py-8 container md:max-w-full">

        <h1 class="text-4xl font-bold mb-10">Offres</h1>

        @if(session('errors'))
            <div class="alert alert-warning mb-4 lg:w-1/5 mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                {{ session('errors') }}
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6">
            {{-- Section de recherche et filtres à gauche --}}
            <div class="lg:w-2/6 mx-10">
                <div class="card bg-base-100">
                    <div class="card-body">
                        <h2 class="card-title">Recherche et filtres</h2>
                        <form action="{{ route('offer.index') }}" method="GET">
                            {{-- Champ de recherche par titre de l'offre --}}
                            <div class="form-control mb-4">
                                <input type="text" name="offer-title" placeholder="Titre de l'offre" class="input input-bordered" value="{{ request('offer-title') }}" />
                                <x-multi-select-filter name="company" label="Entreprise" :items="$companies" key="name" />

                                <div class="form-control w-full mb-4">
                                    <label for="type" class="label">
                                        <span class="label-text">Type de contrat</span>
                                    </label>
                                    <select id="type" name="type[]" multiple class="js-select2 select select-bordered w-full">
                                        @foreach (['CDI', 'CDD', 'Stage', 'Alternance'] as $type)
                                            <option value="{{ $type }}" {{ in_array($type, (array) request('type')) ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <x-multi-select-filter name="industry" label="Secteur d'activité" :items="$industries" key="name" />
                                <x-multi-select-filter name="location" label="Localisation" :items="$locations" key="city" />
                                <x-multi-select-filter name="skill" label="Compétences" :items="$skills" key="skill_name" />
                                <x-multi-select-filter name="sector" label="Secteur" :items="$sectors" key="name" />
                            </div>



                            <div class="form-control flex flex-row gap-2">
                                <button type="submit" class="btn btn-secondary w-full">Filtrer</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            {{-- Section principale d'affichage des entreprises --}}
            <div class="lg:w-full bg-base-100 card card-body overflow-hidden lg:mr-10">
                {{-- Liste des entreprises --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($offers as $offer)
                        <div class="relative">
                            @if (!auth()->user()->hasRole('pilot'))
                                <!-- Bouton Ajouter aux Favoris -->
                                <form action="{{ route('wishlist.store', $offer) }}" method="POST" class="absolute top-2 right-2 z-10">
                                    @csrf
                                    <div class="tooltip tooltip-warning" data-tip="Ajouter aux favoris">
                                        <button class="btn btn-circle btn-outline btn-sm bg-white shadow-md hover:bg-warning">
                                            ❤️
                                        </button>
                                    </div>
                                </form>
                            @endif

                            <!-- Carte de l'Offre -->
                            <div class="card card-bordered shadow-md bg-base-100 relative h-full flex flex-col">
                                @if($offer->companies && $offer->companies->logo_path)
                                    <figure class="bg-gray-100 flex items-center justify-center h-32">
                                        <img
                                            src="{{ Storage::url($offer->companies->logo_path) }}"
                                            alt="{{ 'logo_' . $offer->companies->name }}"
                                            class="max-h-full max-w-full object-contain"
                                        />
                                    </figure>
                                @endif

                                <div class="card-body h-full flex flex-co flex-col">
                                    <h2 class="card-title">
                                        {{ $offer->title }}
                                    </h2>
                                    <p class="text-sm text-gray-600 text-left">
                                        {{ Str::limit($offer->description, 80) }}
                                    </p>

                                    {{-- Badges --}}
                                    <div class="flex flex-wrap items-center gap-2 mt-3">

                                        {{-- Type de contrat --}}
                                        <div class="badge badge-xl badge-primary whitespace-nowrap">
                                            {{ $offer->type }}
                                        </div>

                                        {{-- Salaire --}}
                                        <div class="badge badge-xl badge-accent whitespace-nowrap">
                                            {{ $offer->base_salary }} €
                                        </div>

                                        <div class="badge badge-xl badge-success whitespace-nowrap">
                                            Début {{ $offer->start_offer }}
                                        </div>

                                        {{-- Location --}}
                                        @foreach($offer->companies->addresses as $location)
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
                                        @endforeach

                                    </div>

                                    {{-- Bouton d'action --}}
                                    <div class="card-actions justify-end mt-4">
                                        <a href="{{ route('offer.show', $offer) }}"
                                           class="btn btn-sm btn-primary">
                                            Voir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>

                {{-- Pagination --}}
                {{ $offers->links() }}
            </div>
        </div>
    </div>
@endsection
