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
                        <form action="{{ route('company.search') }}" method="GET">
                            {{-- Champ de recherche par nom d'entreprise --}}
                            <div class="form-control mb-4">
                                <input type="text" name="company-name" placeholder="Nom d'entreprise" class="input input-bordered" value="{{ request('company-name') }}" />
                            </div>

                            {{-- Filtres par industrie --}}
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text">Secteur d'activité</span>
                                </label>
                                @foreach($industries as $industry)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="industry[]" value="{{ $industry->name }}" class="checkbox checkbox-primary"
                                            {{ in_array($industry->name, request('industry', [])) ? 'checked' : '' }} />
                                        <span>{{ $industry->name }}</span>
                                    </label>
                                @endforeach
                            </div>

                            {{-- Filtres par localisation --}}
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text">Localisation</span>
                                </label>
                                @foreach($locations as $location)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="location[]" value="{{ $location->city }}" class="checkbox checkbox-secondary"
                                            {{ in_array($location->city, request('location', [])) ? 'checked' : '' }} />
                                        <span>{{ $location->city }}</span>
                                    </label>
                                @endforeach
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
                {{-- Liste des entreprises --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($companies as $company)
                        <div class="card card-bordered shadow-md bg-base-100">
                            @if($company->logo_path)
                                <figure class="bg-gray-100 flex items-center justify-center h-32">
                                    <img
                                        src="{{ asset($company->logo_path) }}"
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
                                    @foreach($company->addresses as $location)
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

                                    {{-- Note --}}
                                    @php
                                        $rating = round($company->averageRating()); // Note entre 1 et 5
                                    @endphp
                                    <div class="badge badge-xl badge-secondary whitespace-nowrap">
                                        {{ $rating }} ⭐
                                    </div>

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

{{--                <div class="mt-8 flex justify-center lg:justify-end">--}}
{{--                    <x-pagination :paginator="$companies" />--}}

{{--                </div>--}}
                {{ $companies->links() }}
            </div>
        </div>
    </div>
@endsection
