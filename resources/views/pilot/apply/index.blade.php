@extends('layouts.app')

@section('title', 'Gestion candidatures - Talentis')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 space-y-6">

        @if (session('success'))
            <div class="alert alert-success shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 w-6 h-6" fill="none"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m-6 4V9m0 12A9 9 0 1 0 3 12a9 9 0 0 0 18 0 9 9 0 0 0-18 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error shadow-lg">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 w-6 h-6" fill="none"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <ul class="ml-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <h1 class="text-3xl font-bold text-center">Liste des candidatures</h1>

        {{-- Filtres --}}
        <form action="{{ route('pilot.apply.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 justify-center mt-6">
            <input type="text" name="offer_title" placeholder="Titre de l'offre" value="{{ request('offer_title') }}"
                   class="input input-bordered w-full md:max-w-xs">
            <input type="text" name="candidate" placeholder="Nom du candidat" value="{{ request('candidate') }}"
                   class="input input-bordered w-full md:max-w-xs">
            <select name="company" class="select select-bordered w-full md:max-w-xs">
                <option value="">Entreprise</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->name }}" {{ request('company') === $company->name ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary w-full md:w-auto">Rechercher</button>
        </form>

        <div class="flex justify-between mb-6">
            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">← Retour</a>
        </div>

        {{-- Mobile Version --}}
        <div class="md:hidden flex flex-col gap-4 mt-6">
            @forelse ($offers as $offer)
                @foreach ($offer->applies as $user)
                    <div class="bg-white shadow-md rounded-xl p-4">
                        <h2 class="font-bold text-lg">{{ $offer->title }}</h2>
                        <p class="text-gray-600">{{ $offer->companies->name }}</p>
                        <p class="mt-2 text-sm">Candidat : <strong>{{ $user->first_name }} {{ $user->name }}</strong></p>
                        <div class="flex flex-wrap gap-1 mt-2">
                            @foreach ($offer->companies->addresses as $address)
                                <span class="badge badge-ghost">📍 {{ $address->city }}</span>
                            @endforeach
                        </div>
                        <p class="text-sm mt-2">Lettre : {{ $user->pivot->cover_letter ? Str::limit($user->pivot->cover_letter, 80) : 'Non fournie' }}</p>
                        <p class="text-xs text-gray-500">Soumis le : {{ $user->pivot->created_at->format('d/m/Y') }}</p>

                        <div class="flex flex-col gap-2 mt-4">
                            @if ($user->pivot->curriculum_vitae)
                                <a href="{{ Storage::url($user->pivot->curriculum_vitae) }}" target="_blank" class="btn btn-outline btn-sm">Voir CV</a>
                            @else
                                <span class="text-sm text-gray-500 italic">CV non fourni</span>
                            @endif

                            <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $offer->id }}-{{ $user->id }}').showModal()">
                                Retirer
                            </button>
                        </div>
                    </div>
                @endforeach
            @empty
                <p class="text-center text-gray-500">Aucune candidature trouvée.</p>
            @endforelse
        </div>

        {{-- Desktop Version --}}

        <div class="hidden md:block overflow-x-auto mt-8">
            <table class="table w-full bg-white shadow-md rounded-xl text-sm md:text-base">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-center">Poste</th>
                    <th class="border px-4 py-2 text-center">Entreprise</th>
                    <th class="border px-4 py-2 text-center">Candidat</th>
                    <th class="border px-4 py-2 text-center">Localisation</th>
                    <th class="border px-4 py-2 text-center">CV</th>
                    <th class="border px-4 py-2 text-center">Lettre</th>
                    <th class="border px-4 py-2 text-center">Soumis le</th>
                    <th class="border px-4 py-2 text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @if ($offers->isNotEmpty())
                    @foreach ($offers as $offer)
                        @foreach ($offer->applies as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2text-center">{{ $offer->title }}</td>
                                <td class="border px-4 py-2 text-center">{{ $offer->companies->name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $user->first_name }} {{ $user->name }}</td>
                                <td class="border px-4 py-2 text-center">
                                    @foreach ($offer->companies->addresses as $address)
                                        <div class="badge badge-ghost">📍 {{ $address->city }}</div>
                                    @endforeach
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    @if ($user->pivot->curriculum_vitae)
                                        <a href="{{ Storage::url($user->pivot->curriculum_vitae) }}" target="_blank" class="btn btn-outline btn-sm">Voir CV</a>
                                    @else
                                        <span class="text-gray-500 italic text-sm">Non fourni</span>
                                    @endif
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    {{ $user->pivot->cover_letter ? Str::limit($user->pivot->cover_letter, 80) : 'Non fournie' }}
                                </td>
                                <td class="border px-4 py-2 text-center text-gray-500">{{ $user->pivot->created_at->format('d/m/Y') }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $offer->id }}-{{ $user->id }}').showModal()">
                                        Retirer
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="border px-4 py-2 text-center text-gray-500">Aucune candidature trouvée.</td>
                    </tr>
                @endif
                </tbody>
            </table>

            {{ $offers->links() }}
        </div>


        {{-- Modaux --}}
        @foreach ($offers as $offer)
            @foreach ($offer->applies as $user)
                <dialog id="modal-{{ $offer->id }}-{{ $user->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">Confirmer la suppression</h3>
                        <p class="py-4">Êtes-vous sûr de vouloir retirer la candidature de
                            <strong>{{ $user->first_name }} {{ $user->name }}</strong>
                            pour le poste : <strong>{{ $offer->title }}</strong> ?
                        </p>
                        <div class="modal-action flex justify-between">
                            <form method="dialog">
                                <button class="btn">Annuler</button>
                            </form>
                            <form action="{{ route('pilot.apply.remove', [$offer, $user]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-error">Confirmer</button>
                            </form>
                        </div>
                    </div>
                    <form method="dialog" class="modal-backdrop">
                        <button class="cursor-default">Fermer</button>
                    </form>
                </dialog>
            @endforeach
        @endforeach

    </div>
@endsection
