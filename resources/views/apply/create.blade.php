@extends('layouts.app')

@section('title', 'Postuler - Talentis')

@section('content')
<div class="text-center space-y-4 mt-4">
    <a href="{{ route('offer.show', $offer) }}" class="top-4 left-4 btn btn-outline btn-primary">
        ← Retour
    </a>
    <h2 class="text-2xl md:text-4xl font-light opacity-0 animate-fade-in-up delay-300">
        Postulez à cette offre dès maintenant !
    </h2>
</div>

<div class="max-w-4xl mx-auto bg-white p-6 shadow-lg rounded-lg mt-6">
    <h2 class="text-3xl font-bold">{{ $offer->title }}</h2>
    <div class="text-center mb-4">
        <a href="{{ route('company.show', $offer->companies->id) }}"
           class="text-xl font-bold text-primary hover:underline">
            {{ $offer->companies->name }}
        </a>
    </div>
    <p>
        📍 <span class="font-semibold">
                        {{ $offer->companies->addresses->first()->postal_code }}
            {{ $offer->companies->addresses->first()->city }}
                    </span>
    </p>
    <p class="mt-4">{{ $offer->description }}</p>
</div>

<div class="max-w-4xl mx-auto bg-gray p-6 mt-6">
    <h2 class="text-2xl font-bold mb-4">Formulaire de candidature</h2>
    <form action="{{ route('apply.store', $offer) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Téléverser votre CV</legend>
            <input type="file" name="cv" class="file-input w-full" required />
            <label class="fieldset-label">Max size 2MB</label>
        </fieldset>

        <textarea name="cl" placeholder="Votre lettre de motivation" class="textarea textarea-bordered w-full" rows="4"></textarea>

        <button type="submit" class="btn btn-primary w-full text-white">Postuler</button>
    </form>
</div>
@endsection
