@extends('layouts.app')

@section('title', 'Employeurs / Entreprises')

@section('content')
    <div class="container mx-auto py-8">

        <h1 class="text-4xl font-bold mb-10">Employeurs / Entreprises</h1>
        
        @if(session('errors'))
            <div class="alert alert-warning mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                {{ session('errors') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-6">
            {{-- Section de recherche et filtres à gauche --}}
            <div class="md:w-1/4">
                <div class="card bg-base-100">
                    <div class="card-body">
                        <h2 class="card-title">Recherche et filtres</h2>
                        <form action="{{ route('company.search') }}" method="GET">
                            {{-- Barre de recherche --}}
                            <div class="form-control mb-4">
                                <div class="input-group">
                                    <input type="text" name="company-name" placeholder="Nom d'entreprise" class="input input-bordered" />
                                    <button type="submit" class="btn btn-primary">Rechercher</button>
                                </div>
                            </div>
                            {{-- Option de filtre : Industrie --}}
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text">Industrie</span>
                                </label>
                                <select name="industry" class="select select-bordered">
                                    <option value="">Toutes</option>
                                    <option value="tech">Tech</option>
                                    <option value="finance">Finance</option>
                                    <option value="commerce">Commerce</option>
                                </select>
                            </div>
                            {{-- Option de filtre : Localisation --}}
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text">Localisation</span>
                                </label>
                                <select name="location" class="select select-bordered">
                                    <option value="">Toutes</option>
                                    <option value="paris">Paris</option>
                                    <option value="lyon">Lyon</option>
                                    <option value="marseille">Marseille</option>
                                </select>
                            </div>
                            {{-- Bouton pour appliquer les filtres --}}
                            <div class="form-control">
                                <button type="submit" class="btn btn-secondary w-full">Filtrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Section principale d'affichage des entreprises --}}
            <div class="md:w-3/4 bg-base-100 card card-body">
                {{-- Liste des entreprises --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($companies as $company)
                        <div class="card card-bordered shadow-md bg-base-100">
                            {{-- figure: placez l'image/illustration ici si vous avez un logo par exemple --}}
                            @if($company->logo_path)
                                <figure class="bg-gray-100 flex items-center justify-center h-32">
                                    <img
                                        src="{{ asset('storage/'.$company->logo_path) }}"
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
                                <p class="text-sm text-gray-600">
                                    {{ Str::limit($company->description, 80) }}
                                </p>

                                {{-- Badges --}}
                                <div class="flex items-center gap-2 mt-3">
                                    {{--  location --}}
                                    <div class="badge badge-xl badge-ghost">
                                        <svg class="w-4 h-4 mr-1 inline-block" fill="none" stroke="red" stroke-width="2"
                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 11c1.326 0 2.4-.93 2.4-2.077S13.326 6.846 12 6.846s-2.4.93-2.4 2.077S10.674 11 12 11z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 22s8-6.33 8-11.23A8 8 0 104 10.77C4 15.67 12 22 12 22z">
                                            </path>
                                        </svg>
                                        France {{-- $company->location --}}
                                    </div>

                                    {{-- nb job --}}
                                    <div class="badge badge-xl badge-success">
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

                <div class="mt-8 flex justify-center lg:justify-end">
                    <x-pagination :paginator="$companies" />
                </div>
            </div>
        </div>
    </div>
@endsection
