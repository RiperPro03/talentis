@extends('layouts.app')

@section('title', 'Entreprises - Talentis')

@section('content')
    <div class="mx-auto py-8 container md:max-w-full">

        <h1 class="text-4xl font-bold mb-10">Employeurs / Entreprises</h1>

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
                        <form action="{{ route('company.index') }}" method="GET">
                            {{-- Champ de recherche par nom d'entreprise --}}
                            <div class="form-control mb-4">
                                {{-- Filtres par Entreprise --}}
                                <x-multi-select-filter name="company" label="Entreprise" :items="$companies" key="name" />

                                {{-- Filtres par industrie --}}
                                <x-multi-select-filter name="industry" label="Secteur d'activité" :items="$industries" key="name" />

                                {{-- Filtres par localisation --}}
                                <x-multi-select-filter name="location" label="Localisation" :items="$locations" key="city" />
                            </div>



                            {{-- Boutons de filtre et reset --}}
                            <div class="form-control flex flex-row gap-2">
                                <button type="submit" class="btn btn-secondary w-full">Filtrer</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            {{-- Section principale d'affichage des entreprises --}}
            <div class="lg:w-full bg-base-100 card card-body overflow-hidden lg:mr-10">
                @if ($companies->isEmpty())
                    <div class="text-center text-gray-500 text-lg py-10">
                        <p>Aucune entreprise disponible.</p>
                    </div>
                @else
                    {{-- Liste des entreprises --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($companies as $company)
                            <div class="card card-bordered shadow-md bg-base-100">
                                @if($company->logo_path)
                                    <figure class="bg-gray-100 flex items-center justify-center h-32">
                                        <img
                                            src="{{ Storage::url($company->logo_path) }}"
                                            alt="{{ 'logo_' . $company->name }}"
                                            class="max-h-full max-w-full object-contain"
                                        />
                                    </figure>
                                @endif

                                {{-- Corps de la carte --}}
                                <div class="card-body">
                                    <h2 class="card-title">
                                        {{ $company->name }}
                                    </h2>
                                    <p class="text-sm text-gray-600 text-left">
                                        {{ Str::limit($company->description, 80) }}
                                    </p>

                                    {{-- Badges --}}
                                    <div class="flex flex-wrap items-center gap-2 mt-3">
                                        {{-- Location --}}
                                        @if ($company->companies && $company->companies->addresses && $company->companies->addresses->isNotEmpty())
                                            @foreach ($company->companies->addresses as $location)
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
                                        @endif

                                        {{-- Note --}}
                                        @if(!$company->getRate() == 0)
                                            <div class="badge badge-xl badge-secondary whitespace-nowrap">
                                                {{ $company->getRate() }} ⭐
                                            </div>
                                        @endif


                                        {{-- Nombre d'offres --}}
                                        <div class="badge badge-xl badge-success whitespace-nowrap">
                                            {{ $company->offers->count() }} offre(s)
                                        </div>
                                    </div>


                                    {{-- Bouton d'action --}}
                                    <div class="card-actions justify-end mt-4">
                                        <a href="{{ route('company.show', $company) }}"
                                           class="btn btn-sm btn-primary">
                                            Voir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $companies->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection
