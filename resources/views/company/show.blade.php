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

            <div class="mx-auto py-8 container w-5/6 h-48 overflow-hidden rounded-lg flex justify-center items-center">
                <img src="{{ asset('img/test/20220721_180349.jpg') }}"
                     alt="Header Image"
                     class="object-cover w-full h-full rounded-lg">
            </div>
            <h1 class="text-4xl font-bold mb-10">Amaezon</h1>



        <div role="tablist" class="tabs tabs-bordered">
            <!-- Tab 1 -->
            <input type="radio" name="my_tabs_1" id="tab1" role="tab" class="tab" aria-label="Présentation" checked />
            <div role="tabpanel" class="tab-content hidden">
                <div class="flex gap-4">

                    <!-- Ajout de flex ici -->
                    <div class="w-2/3 bg-blue-200 p-4 rounded">
                        <p class="font-bold text-lg text-al">Description</p>
                        <p>Vous avez travaillé ici ? Notez l'entreprise.</p>

                        <form action="/save-rating" method="POST" class="space-y-4">
                            <!-- Protection CSRF pour Laravel -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="rating">
                                <input type="radio" name="rating" class="mask mask-star-2 bg-orange-400" value="1" />
                                <input type="radio" name="rating" class="mask mask-star-2 bg-orange-400" value="2" />
                                <input type="radio" name="rating" class="mask mask-star-2 bg-orange-400" value="3" />
                                <input type="radio" name="rating" class="mask mask-star-2 bg-orange-400" value="4" />
                                <input type="radio" name="rating" class="mask mask-star-2 bg-orange-400" value="5" />
                            </div>

                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Envoyer</button>
                        </form></div>
                    <div class="w-1/3 bg-green-200 p-4 rounded">Partie droite de la présentation</div>
                </div>
            </div>

            <!-- Tab 2 -->
            <input type="radio" name="my_tabs_1" id="tab2" role="tab" class="tab whitespace-nowrap" aria-label="Nos offres"  />
            <div role="tabpanel" class="tab-content hidden">
                <div class="bg-gray-300 p-4 rounded">Contenu de Nos Offres</div>
            </div>
        </div>


@endsection
