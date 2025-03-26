@extends('layouts.app')

@section('content')
    <div class="flex flex-col justify-center items-center min-h-[75vh]">
        <div class="max-w-5xl w-full p-4 sm:p-6 flex flex-col lg:flex-row lg:gap-10 items-stretch">

            <!-- Section Profil -->
            <div class="card bg-base-100 text-neutral-content py-12 sm:py-14 rounded-lg shadow-lg border w-full lg:w-1/3 flex flex-col justify-between">
                <h3 class="text-lg sm:text-xl font-bold text-center text-neutral mb-6">Profil</h3>
                <div class="flex flex-col items-center space-y-6 sm:space-y-8">
                    <div class="avatar">
                        <div class="w-32 sm:w-36 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img src="#" alt="Photo de profil">
                        </div>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold">{{$user->first_name}} {{$user->name}}</h3>
                    <p class="text-sm sm:text-base font-medium">📅 Date de naissance : <span class="font-semibold">{{$user->birthdate}}</span></p>
                    <p class="text-sm sm:text-base font-medium">🎓 Promotion : <span class="font-semibold">{{$user->promotion->promotion_code}}</span></p>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="card bg-base-100 p-10 sm:p-12 rounded-lg shadow-lg border flex flex-col justify-between w-full lg:w-2/3">
                <h3 class="text-lg sm:text-xl font-bold text-center text-neutral mb-6">Statistiques</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="stat bg-primary text-primary-content rounded-lg p-8 flex flex-col items-center justify-center text-center">
                        <div class="stat-title text-sm sm:text-base font-medium">Annonces Likées</div>
                        <div class="stat-value text-xl sm:text-2xl font-bold">74</div>
                    </div>
                    <div class="stat bg-secondary text-secondary-content rounded-lg p-8 flex flex-col items-center justify-center text-center">
                        <div class="stat-title text-sm sm:text-base font-medium">Annonces Postulées</div>
                        <div class="stat-value text-xl sm:text-2xl font-bold">46</div>
                    </div>
                    <div class="stat bg-accent text-accent-content rounded-lg p-8 flex flex-col items-center justify-center text-center">
                        <div class="stat-title text-sm sm:text-base font-medium">Réponses Positives</div>
                        <div class="stat-value text-xl sm:text-2xl font-bold">3</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wishlist et Candidatures -->
        <div class="max-w-5xl w-full p-4 sm:p-6 flex flex-col lg:flex-row lg:gap-10 items-stretch mt-8">

            <!-- Wishlist -->
            <div class="card bg-base-100 p-6 rounded-lg shadow-lg border w-full lg:w-1/2">
                <h3 class="text-lg sm:text-xl font-bold text-center text-neutral mb-4">Ma Wishlist</h3>
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">Titre</th>
                            <th class="px-4 py-2">Entreprise</th>
                            <th class="px-4 py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wishlist as $offre)
                            <tr>
                                <td class="border px-4 py-2">{{ $offre->title }}</td>
                                <td class="border px-4 py-2">{{ $offre->company}}</td>
                                <td class="border px-4 py-2">{{ $offre->date }}</td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
                <div class="text-center mt-4">
                    <a href="{{ route('wishlist.index') }}" class="text-blue-500 font-semibold">Voir plus</a>
                </div>
            </div>

            <!-- Candidatures -->
            <div class="card bg-base-100 p-6 rounded-lg shadow-lg border w-full lg:w-1/2">
                <h3 class="text-lg sm:text-xl font-bold text-center text-neutral mb-4">Mes Candidatures</h3>
                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">Titre</th>
                            <th class="px-4 py-2">Entreprise</th>
                            <th class="px-4 py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applies as $candidature)
                            <tr>
                                <td class="border px-4 py-2">{{ $candidature->title }}</td>
                                <td class="border px-4 py-2">{{ $candidature->companies->name }}</td>
                                <td class="border px-4 py-2">{{ $candidature->pivot->created_at->format('d/m/Y à H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center mt-4">
                    <a href="{{ route('apply.index') }}" class="text-blue-500 font-semibold">Voir plus</a>
                </div>
            </div>

        </div>
    </div>
@endsection
