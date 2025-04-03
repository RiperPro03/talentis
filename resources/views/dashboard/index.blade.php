@extends('layouts.app')

@section('title', 'Tableau de bord - Talentis')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 space-y-10">
        <!-- Titre -->
        <h1 class="text-4xl md:text-5xl font-bold text-center text-gray-800 mb-8">📊 Statistiques</h1>

        <!-- Statistiques -->
        <div class="stats stats-vertical lg:stats-horizontal shadow-lg w-full bg-white rounded-2xl">

            <div class="stat">
                <div class="stat-title">Nombre de Pilotes</div>
                <div class="stat-value text-blue-600">{{ $pilotCount }}</div>
            </div>

            <div class="stat">
                <div class="stat-title">Nombre d'Étudiants</div>
                <div class="stat-value text-green-600">{{ $studentCount }}</div>
            </div>

            <div class="stat">
                <div class="stat-title">Offres publiées</div>
                <div class="stat-value text-yellow-500">{{ $offerCount }}</div>
            </div>

            <div class="stat">
                <div class="stat-title">Entreprises partenaires</div>
                <div class="stat-value text-purple-600">{{ $companyCount }}</div>
            </div>

            <div class="stat">
                <div class="stat-title">Moyenne Offres/Jour</div>
                <div class="stat-value text-red-500">{{ $averageOffersPerDay }}</div>
            </div>
        </div>

        <!-- Liens CRUD -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <a href="{{ route('student.index') }}" class="btn btn-outline btn-primary w-full">Gérer Student</a>
            <a href="{{ route('pilot.company.index') }}" class="btn btn-outline btn-secondary w-full">Gérer Company</a>
            <a href="{{ route('pilot.offer.index') }}" class="btn btn-outline btn-accent w-full">Gérer Offer</a>
            <a href="{{ route('promotion.index') }}" class="btn btn-outline btn-info w-full">Gérer Promotion</a>
            <a href="{{ route('skill.index') }}" class="btn btn-outline btn-success w-full">Gérer Skill</a>
            <a href="{{ route('sector.index') }}" class="btn btn-outline btn-warning w-full">Gérer Sector</a>
            <a href="{{ route('industry.index') }}" class="btn btn-outline btn-error w-full">Gérer Industry</a>
            <a href="{{ route('pilot.apply.index') }}" class="btn btn-outline btn-neutral w-full">Gérer Apply</a>
            <a href="{{ route('address.index') }}" class="btn btn-outline w-full">Gérer Address</a>
        </div>
    </div>
@endsection
