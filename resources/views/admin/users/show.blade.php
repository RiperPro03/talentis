@extends('layouts.dashboard-admin')

@section('title', 'Tableau de board - Talentis')

@section('content')

<div class="bg-base-200">

    <!-- Conteneur principal qui doit couvrir toute la page et la largeur -->
    <div class="min-h-screen w-full bg-base-200 flex">

        <!-- Contenu principal -->
        <div class="flex-1 p-6 lg:ml-64 mt-16 w-full"> <!-- Ajout de w-full pour que le contenu prenne toute la largeur -->

            <div class="w-full max-w-4xl bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    📋 Données de la table : <span class="text-primary">{{ ucfirst($table) }}</span>
                </h3>

                <!-- Bouton Ajouter - Redirige vers la page d'insertion -->
                <div class="mb-4 flex justify-end ">
                    <a href="{{ url($table . '/insert') }}" class="btn btn-primary text-white">
                        ➕ Ajouter une donnée
                    </a>
                </div>

                <!-- Affichage des données avec ajout de overflow-x-auto -->
                <div class="overflow-x-auto">
                    @if ($table == 'pilot')
                        @if ($pilot->isEmpty())
                            <p class="text-center text-gray-500">Aucune donnée disponible dans la table des pilotes.</p>
                        @else
                            @foreach($pilot as $item)
                                <x-table-row :item="$item" :table="'pilot'" />
                            @endforeach
                        @endif
                    @else
                        <p>Table non trouvée.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
