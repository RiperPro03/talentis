@extends('layouts.app')


@section('title', 'Créer un compte étudiant')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-10">
        <h2 class="text-2xl font-bold mb-6">Modifier l'utilisateur</h2>

        @if (session('success'))
            <div class="alert alert-success shadow-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error shadow-lg mb-4">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <div>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif


        <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @if ($errors->any())
                <div class="bg-red-500 text-white p-2 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif




            <div>
                <label class="block font-medium">Nom</label>
                <input type="text" name="name" placeholder="Entrez le nom ici"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Prénom</label>
                <input type="text" name="first_name" placeholder="Entrez le prénom ici"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('first_name')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Date de naissance</label>
                <input type="date" name="birthdate" placeholder="Entrez la date de naissance"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('birthdate')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Email</label>
                <input type="email" name="email" placeholder="Entrez le mail."
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Mot de passe</label>
                <input type="password" name="password"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-medium">Code Postal</label>
                <input type="text" name="postal_code" placeholder="Entrez le code postal"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('postal_code')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Ville</label>
                <input type="text" name="city" placeholder="Entrez la ville"
                    class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('city')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Promotion</label>

                <x-multi-select-filter name="promotion" label="" :items="$promotions" key="promotion_code"
                    :multiple="false" :default="null" :selectedItems="[]" />



            </div>


            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Enregistrer</button>
            </div>
        </form>
    </div>

    <a href="{{ route('student.index') }}"
        class="btn btn-secondary w-fit mx-auto mt-4 px-6 py-2 flex items-center justify-center">
        ← Retour
    </a>


@endsection
