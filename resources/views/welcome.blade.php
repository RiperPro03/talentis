@extends('layouts.app')

@section('title', 'Accueil - Talentis')

@section('content')

<div class="text-center space-y-4">
    <h1 class="animate-gradient-text text-6xl md:text-9xl font-bold bg-clip-text text-transparent
                        bg-gradient-to-r from-primary via-secondary to-accent
                        bg-[length:200%_auto] md:bg-[length:250%_auto]
                        transition-all duration-1000">
        Talentis
    </h1>

    <h2 class="text-2xl md:text-4xl font-light opacity-0 animate-fade-in-up delay-300">
        Your Gateway to Opportunity!
    </h2>
</div>

<!-- SEARCH BAR -->
<div
    class="flex flex-col md:flex-row items-center justify-center gap-2 md:gap-4 bg-white p-6 shadow-lg rounded-lg w-full max-w-4xl mx-auto mt-4">
    <!-- Input: Vous cherchez ? -->
    <input type="text" placeholder="Vous cherchez ?" class="input input-bordered w-full md:w-1/4"/>

    <!-- Input: Où ? -->
    <input type="text" placeholder="Où ?" class="input input-bordered w-full md:w-1/4"/>

    <!-- Select: Type d'emploi -->
    <select class="select select-bordered w-full md:w-1/4">
        <option disabled selected>Type d'emploi</option>
        <option>CDI</option>
        <option>CDD</option>
        <option>Stage</option>
        <option>Alternance</option>
    </select>

    <!-- Bouton de recherche -->
    <button class="btn btn-primary text-white w-full md:w-auto">
        Rechercher
    </button>
</div>



<!-- Container principal du carousel -->
<div class="relative w-full max-w-6xl mx-auto mt-6">
    <!-- Carousel avec cartes -->
    <div id="carousel" class="flex gap-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory px-4 scroll-smooth">

        <!-- Card 1 -->
        <div class="carousel-item w-80 snap-center shrink-0">
            <div class="card bg-base-100 shadow-xl">
                <figure class="px-6 pt-6">
                    <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                         alt="Shoes" class="rounded-xl"/>
                </figure>
                <div class="card-body items-center text-center">
                    <h2 class="card-title">Shoes!</h2>
                    <p>If a dog chews shoes whose shoes does he choose?</p>
                    <div class="card-actions">
                        <button class="btn btn-primary">More</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="carousel-item w-80 snap-center shrink-0">
            <div class="card bg-base-100 shadow-xl">
                <figure class="px-6 pt-6">
                    <img src="{{ asset('img/test/20220714_173115.jpg') }}" alt="Hat" class="rounded-xl"/>
                </figure>
                <div class="card-body items-center text-center">
                    <h2 class="card-title">Hat!</h2>
                    <p>Why do hats make you look so cool?</p>
                    <div class="card-actions">
                        <button class="btn btn-primary">More</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="carousel-item w-80 snap-center shrink-0">
            <div class="card bg-base-100 shadow-xl">
                <figure class="px-6 pt-6">
                    <img src="{{ asset('img/test/20220721_180349.jpg') }}" alt="Watch" class="rounded-xl"/>
                </figure>
                <div class="card-body items-center text-center">
                    <h2 class="card-title">Watch!</h2>
                    <p>Time flies when you're having fun!</p>
                    <div class="card-actions">
                        <button class="btn btn-primary">More</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="carousel-item w-80 snap-center shrink-0">
            <div class="card bg-base-100 shadow-xl">
                <figure class="px-6 pt-6">
                    <img src="{{ asset('img/test/20221228_094237.jpg') }}" alt="Sunglasses" class="rounded-xl"/>
                </figure>
                <div class="card-body items-center text-center">
                    <h2 class="card-title">Sunglasses!</h2>
                    <p>Protect your eyes in style.</p>
                    <div class="card-actions">
                        <button class="btn btn-primary">More</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="carousel-item w-80 snap-center shrink-0">
            <div class="card bg-base-100 shadow-xl">
                <figure class="px-6 pt-6">
                    <img src="{{ asset('img/test/IMG_6724-min-scaled.jpg') }}" alt="Sunglasses" class="rounded-xl"/>
                </figure>
                <div class="card-body items-center text-center">
                    <h2 class="card-title">Sunglasses!</h2>
                    <p>Protect your eyes in style.</p>
                    <div class="card-actions">
                        <button class="btn btn-primary">More</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Boutons de navigation visibles uniquement sur PC (`lg:`) -->
    <button id="prev"
            class="hidden lg:flex absolute left-0 top-1/2 transform -translate-y-1/2 btn btn-circle btn-primary">❮
    </button>
    <button id="next"
            class="hidden lg:flex absolute right-0 top-1/2 transform -translate-y-1/2 btn btn-circle btn-primary">❯
    </button>
</div>
@endsection
