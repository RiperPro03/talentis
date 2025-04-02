@extends('layouts.app')

@section('title', 'Tableau de bord - Talentis')

@section('content')

    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-7xl mx-auto p-10">
            <!-- Titre des statistiques -->
            <h1 id="statsTitle" class="text-4xl font-bold text-gray-800 mb-8 text-center bg-white py-2 px-4 shadow-md lg:text-5xl">
                📊 Statistiques
            </h1>

            <!-- Conteneur des statistiques -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="p-6 bg-white shadow-lg rounded-xl border text-center">
                    <div class="stat-title text-lg">Nombre de Pilotes</div>
                    <div class="stat-value text-blue-600 text-5xl">{{ $pilotCount }}</div>
                </div>
                <div class="p-6 bg-white shadow-lg rounded-xl border text-center">
                    <div class="stat-title text-lg">Nombre d'Étudiants</div>
                    <div class="stat-value text-green-600 text-5xl">{{ $studentCount }}</div>
                </div>
                <div class="p-6 bg-white shadow-lg rounded-xl border text-center">
                    <div class="stat-title text-lg">Offres publiées</div>
                    <div class="stat-value text-yellow-600 text-5xl">{{ $offerCount }}</div>
                </div>
            </div>

            <!-- Deux autres statistiques en bas, centrées avec un espace plus grand au milieu -->
            <div class="flex justify-center gap-x-12 mt-6">
                <div class="p-6 bg-white shadow-lg rounded-xl border text-center w-96">
                    <div class="stat-title text-lg">Entreprises partenaires</div>
                    <div class="stat-value text-purple-600 text-5xl">{{ $companyCount }}</div>
                </div>
                <div class="p-6 bg-white shadow-lg rounded-xl border text-center w-96">
                    <div class="stat-title text-lg">Moyenne Offres/Jour</div>
                    <div class="stat-value text-red-600 text-5xl">{{ $averageOffersPerDay }}</div>
                </div>
            </div>

            <!-- Cartes de redirection CRUD -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-6 mt-10">
                <a href="{{ route('student.index') }}" class="p-6 bg-white shadow-lg rounded-xl border text-center">Gérer Student</a>
                <a href="{{ route('pilot.company.index') }}" class="p-6 bg-white shadow-lg rounded-xl border text-center">Gérer Company</a>
                <a href="{{ route('pilot.offer.index') }}" class="p-6 bg-white shadow-lg rounded-xl border text-center">Gérer Offer</a>
                <a href="{{ route('promotion.index') }}" class="p-6 bg-white shadow-lg rounded-xl border text-center">Gérer Promotion</a>
                <a href="{{ route('skill.index') }}" class="p-6 bg-white shadow-lg rounded-xl border text-center">Gérer Skill</a>
                <a href="{{ route('sector.index') }}" class="p-6 bg-white shadow-lg rounded-xl border text-center">Gérer Sector</a>
                <a href="{{ route('industry.index') }}" class="p-6 bg-white shadow-lg rounded-xl border text-center">Gérer Industry</a>
                <a href="{{ route('pilot.apply.index') }}" class="p-6 bg-white shadow-lg rounded-xl border text-center">Gérer Apply</a>
            </div>
        </div>
    </div>

@endsection
