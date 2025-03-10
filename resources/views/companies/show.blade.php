@extends('layouts.app')

@section('title', 'Employeurs / Entreprises')

@section('content')
<div class="container mx-auto p-0">
    <div class="relative bg-green-900 text-white h-64 flex flex-col justify-center items-center">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/images/header-background.jpg');"></div>
        <div class="absolute inset-0 bg-green-900 opacity-95"></div>
        <div class="relative z-10 text-center">
            <h1 class="text-4xl font-bold">Employers / Companies</h1>
            <nav class="text-gray-300 text-sm mt-2">
                <a href="#" class="text-white hover:underline">Jobstack</a> >
                <a href="#" class="text-white hover:underline">Jobs</a> >
                <span class="font-semibold text-white">Employers</span>
            </nav>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-12 mt-12">
        @foreach($companies as $company)
            <div class="bg-white shadow-md hover:shadow-lg p-6 rounded-xl flex flex-col items-center text-center border border-gray-200 transition-all w-full max-w-xs mx-auto">
                <div class="bg-gray-100 p-3 rounded-full shadow flex items-center justify-center w-12 h-12">
                    <img src="/images/{{ $company['logo'] }}" alt="{{ $company['name'] }} Logo" class="w-10 h-10 object-contain">
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mt-4">{{ $company['name'] }}</h3>
                <p class="text-gray-500 text-sm mt-1">Digital Marketing Solutions for Tomorrow</p>
                <p class="text-gray-400 text-xs mt-1 flex items-center"><span class="mr-1">📍</span>{{ $company['location'] }}</p>
                <p class="text-green-600 font-semibold mt-3">{{ $company['jobs'] }} Jobs</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
