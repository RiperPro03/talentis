@extends('layouts.app')

@section('title', 'Modifier un étudiant')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-xl mt-10 space-y-6">
        <h2 class="text-3xl font-bold text-center mb-6">Modifier l'étudiant</h2>

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

        <form action="{{ route('student.update', $student) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="label font-medium">Nom</label>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}"
                           class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Prénom</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}"
                           class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Date de naissance</label>
                    <input type="date" name="birthdate" value="{{ old('birthdate', $student->birthdate) }}"
                           class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email', $student->email) }}"
                           class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Nouveau mot de passe</label>
                    <input type="password" name="password" class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Confirmer mot de passe</label>
                    <input type="password" name="password_confirmation" class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Code Postal</label>
                    <input type="text" name="postal_code"
                           value="{{ old('postal_code', $student->addresses->postal_code ?? 'Non assigné') }}"
                           class="input input-bordered w-full">
                </div>

                <div>
                    <label class="label font-medium">Ville</label>
                    <input type="text" name="city"
                           value="{{ old('city', $student->addresses->city ?? 'Non assigné') }}"
                           class="input input-bordered w-full">
                </div>
            </div>

            <div>
                <label class="label font-medium">Promotion</label>

                @if (is_null($student->promotion_id))
                    <div class="mt-2 text-sm text-red-600">Cet étudiant n'a actuellement pas de promotion, veuillez lui en attribuer une.</div>
                @endif

                <x-multi-select-filter name="promotion" label="" :items="$promotions" key="promotion_code"
                                       :multiple="false"
                                       :default="$student->promotion ? $student->promotion->promotion_code : null"
                                       :selectedItems="$student->promotion_id ? [$student->promotion->promotion_code] : []" />
            </div>

            <div>
                <label class="label font-medium">Photo de profil</label>
                <input type="file" name="profile_picture" accept="image/png, image/jpeg"
                       class="file-input file-input-bordered w-full">
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('student.index') }}" class="btn btn-secondary">
                    ← Retour
                </a>
                <button type="submit" class="btn btn-primary">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
@endsection
