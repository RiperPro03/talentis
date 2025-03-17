@extends('layouts.app')

@section('title', 'Postuler - Talentis')

@section('content')
<div class="text-center space-y-4">
    <h1 class="mt-4 animate-gradient-text text-6xl md:text-9xl font-bold bg-clip-text text-transparent
                        bg-gradient-to-r from-primary via-secondary to-accent
                        bg-[length:200%_auto] md:bg-[length:250%_auto]
                        transition-all duration-1000">
        
    </h1>

    <h2 class="text-2xl md:text-4xl font-light opacity-0 animate-fade-in-up delay-300">
        Postulez à cette offre dès maintenant !
    </h2>
</div>

<div class="max-w-4xl mx-auto bg-white p-6 shadow-lg rounded-lg mt-6">
    <h2 class="text-3xl font-bold">Titre de l'offre</h2>
    <p class="text-gray-600 mt-2">Entreprise: </p>
    <p class="text-gray-600">Lieu: </p>
    <p class="mt-4">Ici nous pouvons mettre une petite description de l'offre</p>
</div>

<div class="max-w-4xl mx-auto bg-gray p-6 shadow-lg rounded-lg mt-6">
    <h2 class="text-2xl font-bold mb-4">Formulaire de candidature</h2>
    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        
        <input type="text" name="name" placeholder="Nom" class="input input-bordered w-full" required/>
        <input type="text" name="name" placeholder="Prénom" class="input input-bordered w-full" required/>
        <input type="text" name="address" placeholder="Adresse" class="input input-bordered w-full" required/>
        <input type="email" name="email" placeholder="Email" class="input input-bordered w-full" required/>
        <input type="tel" name="phone" placeholder="Téléphone" class="input input-bordered w-full" required/>
        
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Téléverser votre CV</legend>
            <input type="file" name="cv" class="file-input w-full" required />
            <label class="fieldset-label">Max size 2MB</label>
        </fieldset>
        
        <textarea name="message" placeholder="Votre lettre de motivation" class="textarea textarea-bordered w-full" rows="4"></textarea>
        
        <button type="submit" class="btn btn-primary w-full text-white">Postuler</button>
    </form>
</div>
@endsection
