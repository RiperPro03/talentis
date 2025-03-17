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
            <h1 class="text-4xl font-bold mb-10">{{ $company->name }}</h1>



        <div role="tablist" class="tabs tabs-bordered">
            <!-- Tab 1 -->
            <input type="radio" name="my_tabs_1" id="tab1" role="tab" class="tab" aria-label="Présentation" checked />
            <div role="tabpanel" class="tab-content hidden">
                <div class="flex flex-col md:flex-row gap-4 items-start md:items-stretch h-full">

                    <!-- Ajout de flex ici -->
                    <div class="w-full md:w-2/3 p-4 rounded h-full flex-1">

                        <p class="font-bold text-lg text-al">Description</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam rhoncus diam et consequat vestibulum. Quisque vel magna vitae turpis viverra pulvinar. Ut finibus neque eu erat vehicula, eu posuere mauris euismod. Sed ornare luctus maximus. Donec vitae neque ligula. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean dictum odio in pretium semper. Curabitur dignissim odio non tempor sollicitudin. Etiam tristique elit in quam molestie vulputate.

                            Maecenas placerat sem nunc. Fusce non urna viverra, pellentesque justo tristique, vulputate neque. Fusce porttitor dictum sagittis. Proin auctor, orci et dignissim tempus, dolor velit congue lacus, nec hendrerit massa diam at orci. Fusce euismod erat vitae augue semper consequat. Ut id pellentesque dolor. Nulla et congue neque, vel accumsan nulla. Morbi fermentum nisi eu leo cursus laoreet. Donec at gravida tellus, eget congue odio.

                            Nullam quis dolor at nulla placerat fringilla in non massa. Sed vel nunc in mauris semper lacinia at quis sem. Mauris venenatis vestibulum fermentum. Praesent fringilla ligula vel tortor feugiat, eu fringilla eros bibendum. Donec eu ex quis ligula vestibulum aliquam. Donec vitae nulla condimentum turpis vestibulum auctor. Maecenas luctus suscipit velit eget ullamcorper. Vestibulum scelerisque euismod magna. Fusce laoreet nunc id urna luctus accumsan. Vivamus sit amet ullamcorper magna. Duis a arcu luctus, aliquam eros in, interdum mi. Integer a hendrerit ante. Sed sagittis enim vel efficitur dapibus. Morbi rutrum ornare odio quis pretium. Morbi eget libero purus. Aenean nec facilisis magna, sit amet pharetra est.</p>
                        <br>

                        <p class="font-bold text-lg text-al">Où nous trouver ?</p>
                        <br>
                        <div class="flex justify-center items-center gap-4">
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
                                test
                            </div>
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
                                test2
                            </div>

                        </div>

                        <br>
                        <p class="font-bold text-lg text-al">Vous avez travaillé ici ? Notez l'entreprise.</p>

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
                        </form>
                    <br>
                    <p class="font-bold text-lg text-al">Cette entreprise est actuellement notée:</p>
                        @php $rating = round($company->averageRating()); // Note entre 1 et 5@endphp



                        <div class="flex justify-center items-center mt-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                     fill="currentColor"
                                     viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.049 3.012a1 1 0 011.902 0l1.342 3.767a1 1 0 00.95.69h3.993a1 1 0 01.592 1.81l-3.235 2.36a1 1 0 00-.364 1.118l1.236 3.784a1 1 0 01-1.54 1.118l-3.23-2.36a1 1 0 00-1.176 0l-3.23 2.36a1 1 0 01-1.54-1.118l1.236-3.784a1 1 0 00-.364-1.118l-3.235-2.36a1 1 0 01.592-1.81h3.993a1 1 0 00.95-.69l1.342-3.767z"></path>
                                </svg>
                            @endfor
                        </div>
                    </div>





                    <div class="w-1/3 p-4  hidden md:block">
                        <div class=" p-4 ">
                            <h2 class="text-xl font-bold mb-4">Dernières offres</h2>
                            @if($company->offers->isEmpty())
                                <p>Aucune offre disponible.</p>
                            @else
                                <ul class="space-y-4">
                                    @foreach($company->offers as $offer)



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


                                                    {{-- Note --}}



                                                    {{-- Nombre d'offres --}}
                                                    <div class="badge badge-xl badge-success whitespace-nowrap">
                                                        {{ $offer->base_salary }}€
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
                                </ul>
                            @endif
                        </div>




                    </div>

                </div>



            </div>

            <!-- Tab 2 -->
            <input type="radio" name="my_tabs_1" id="tab2" role="tab" class="tab whitespace-nowrap" aria-label="Nos offres"  />
            <div role="tabpanel" class="tab-content hidden">
                <div class="bg-gray-300 p-4 rounded">Contenu de Nos Offres</div>
            </div>
        </div>


@endsection
