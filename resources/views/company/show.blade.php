@extends('layouts.app')

@section('title', 'Entreprises - Talentis')

@section('content')

        @if(session('errors'))
            <div class="alert alert-warning mb-4 lg:w-1/5 mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                {{ session('errors') }}
            </div>
        @endif

        <a href="{{ route('company.index') }}" class="btn btn-outline btn-primary">
            ← Retour
        </a>

        <div class="mx-auto py-8 container w-5/6 h-auto overflow-hidden rounded-lg flex justify-center items-center">
            <img src="{{ asset($company->logo_path) }}"
                 alt="Logo de l'entreprise"
                 class="object-contain w-full max-h-64 rounded-lg">
        </div>

        <h1 class="text-4xl font-bold mb-10">{{ $company->name }}</h1>

        <div class="stats shadow">
            <div class="stat">
                <div class="stat-title">Nombre de candidatures</div>
                <div class="stat-value">{{ $appliesCount }}</div>
                <div class="stat-desc">utilisateur(s) ont postulé à une offre de cette entreprise.</div>
            </div>
        </div>


        <div role="tablist" class="tabs tabs-bordered">
            <!-- Tab 1 -->
            <input type="radio" name="my_tabs_1" id="tab1" role="tab" class="tab" aria-label="Présentation" checked />
            <div role="tabpanel" class="tab-content hidden">
                <div class="flex flex-col md:flex-row gap-4 items-start md:items-stretch h-full">

                    <div class="w-full md:w-2/3 p-4 rounded h-full flex-1">
                        <p class="font-bold text-lg text-al">Description</p>

                        @if ($company->industries->isNotEmpty())
                            @foreach ($company->industries as $industry)
                                <span class="badge bg-blue-600 text-white px-3 py-1 text-sm rounded-full">
                                    {{ $industry->name }}
                                </span>
                            @endforeach
                        @endif

                        <p>{{ $company->description }}</p>


                        <p class="font-bold text-lg text-al">Où nous trouver ?</p>
                        <div class="flex justify-center items-center gap-4">
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
                        </div>

                        <br>
                        <p class="font-bold text-lg text-al">Vous avez travaillé ici ? Notez l'entreprise.</p>

                        <form action="{{ route('company.rate', $company) }}" method="POST" class="space-y-4">
                            @csrf

                            @php
                                $existingRating = $company->evaluations->where('id', auth()->id())->first()?->pivot->rating;
                            @endphp

                            <div class="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating"
                                           class="mask mask-star-2 bg-orange-400"
                                           value="{{ $i }}"
                                        {{ ($existingRating !== null && $existingRating == $i) || ($existingRating === null && $i == 5) ? 'checked' : '' }} />
                                @endfor
                            </div>

                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Envoyer</button>
                        </form>
                    <br>
                    <p class="font-bold text-lg text-al">Cette entreprise est actuellement notée:</p>

                        <div class="flex justify-center items-center mt-2">
                            @if($company->getRate() == 0)
                                <p class="text-gray-500">Aucune note disponible.</p>


                            @else
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $company->getRate() ? 'text-yellow-400' : 'text-gray-300' }}"
                                         fill="currentColor"
                                         viewBox="0 0 20 20"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.049 3.012a1 1 0 011.902 0l1.342 3.767a1 1 0 00.95.69h3.993a1 1 0 01.592 1.81l-3.235 2.36a1 1 0 00-.364 1.118l1.236 3.784a1 1 0 01-1.54 1.118l-3.23-2.36a1 1 0 00-1.176 0l-3.23 2.36a1 1 0 01-1.54-1.118l1.236-3.784a1 1 0 00-.364-1.118l-3.235-2.36a1 1 0 01.592-1.81h3.993a1 1 0 00.95-.69l1.342-3.767z"></path>
                                    </svg>
                                @endfor
                            @endif
                        </div>
                    </div>





                    <div class="w-1/3 p-4  hidden md:block">
                        <div class=" p-4 ">
                            <h2 class="text-xl font-bold mb-4">Dernières offres</h2>
                            @if($company->offers->isEmpty())
                                <p>Aucune offre disponible.</p>
                            @else
                                <ul class="space-y-4">
                                    @foreach($company->latestOffers() as $offer)



                                        <div class="card card-bordered shadow-md bg-base-100">


                                            {{-- Corps de la carte --}}
                                            <div class="card-body">
                                                <h2 class="card-title">
                                                    {{ $offer->title }}
                                                </h2>
                                                <p class="text-sm text-gray-600 text-left">
                                                    {{ Str::limit($offer->description, 80) }}
                                                </p>
                                                <p class="text-gray-500 text-sm">
                                                    Publiée le {{ $offer->created_at->format('d/m/Y') }}
                                                </p>

                                                {{-- Badges --}}
                                                <div class="flex flex-wrap items-center gap-2 mt-3">
                                                    {{-- Location --}}

                                                        <div class="badge badge-xl badge-ghost whitespace-nowrap flex items-center">

                                                            {{ $offer->type }}
                                                        </div>
                                                    <div class="badge badge-xl badge-primary whitespace-nowrap flex items-center">

                                                        {{ $offer->sector->name }}
                                                    </div>


                                                    {{-- Note --}}



                                                    {{-- Nombre d'offres --}}
                                                    <div class="badge badge-xl badge-success whitespace-nowrap">
                                                        {{ $offer->base_salary }}€
                                                    </div>
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
                                    @endforeach
                                </ul>
                            @endif
                        </div>




                    </div>

                </div>



            </div>

            <!-- Tab 2 -->
            <a href="{{ route('offer.index', ['company' => [$company->name]]) }}" class="tab whitespace-nowrap">
                Nos offres
            </a>


        </div>



@endsection
