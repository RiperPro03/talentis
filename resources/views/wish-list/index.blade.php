@extends('layouts.app')

@section('title', 'Wish-list d\'Offres')

@section('content')
    <div class="container mx-auto py-6 px-4">
        {{-- Bouton de retour en haut à gauche --}}
        <div class="flex justify-start mb-4">
            <button onclick="window.history.back();" class="btn btn-secondary">← Retour</button>
        </div>

        <h1 class="text-2xl md:text-4xl font-bold mb-6 text-center">Wish-list d'Offres</h1>

        <div class="overflow-x-auto">
            <table class="table w-full border-collapse border border-gray-200 text-sm md:text-base">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="border px-2 md:px-4 py-2">Poste</th>
                        <th class="border px-2 md:px-4 py-2">Entreprise</th>
                        <th class="border px-2 md:px-4 py-2">Localisation</th>
                        <th class="border px-2 md:px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Exemple de données statiques --}}
                    <tr class="hover:bg-gray-50">
                        <td class="border px-2 md:px-4 py-2">Développeur Full-Stack</td>
                        <td class="border px-2 md:px-4 py-2">TechCorp</td>
                        <td class="border px-2 md:px-4 py-2">Paris</td>
                        <td class="border px-2 md:px-4 py-2 flex flex-col md:flex-row gap-2 justify-center">
                            <a href="#" class="btn btn-sm btn-primary w-full md:w-auto">Voir</a>
                            <button class="btn btn-sm btn-error w-full md:w-auto">Retirer</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="border px-2 md:px-4 py-2">Analyste Financier</td>
                        <td class="border px-2 md:px-4 py-2">FinancePlus</td>
                        <td class="border px-2 md:px-4 py-2">Lyon</td>
                        <td class="border px-2 md:px-4 py-2 flex flex-col md:flex-row gap-2 justify-center">
                            <a href="#" class="btn btn-sm btn-primary w-full md:w-auto">Voir</a>
                            <button class="btn btn-sm btn-error w-full md:w-auto">Retirer</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="border px-2 md:px-4 py-2">Chef de Projet Marketing</td>
                        <td class="border px-2 md:px-4 py-2">MarketLeader</td>
                        <td class="border px-2 md:px-4 py-2">Marseille</td>
                        <td class="border px-2 md:px-4 py-2 flex flex-col md:flex-row gap-2 justify-center">
                            <a href="#" class="btn btn-sm btn-primary w-full md:w-auto">Voir</a>
                            <button class="btn btn-sm btn-error w-full md:w-auto">Retirer</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
