@extends('layouts.app')

@section('title', 'Index des promotions')

@section('content')
    <div class="container mx-auto py-6 px-4">
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

        <h1 class="text-lg md:text-4xl font-bold mb-6 text-center">Les promotions</h1>

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('promotion.index') }}" class="mb-6 flex items-center gap-2">
            <input type="text" name="promotion_code" value="{{ request('promotion_code') }}"
                   placeholder="Rechercher une promotion" class="input input-bordered w-full max-w-xs">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>

        <div class="hidden md:block overflow-x-auto">
            <table class="table w-full border-collapse border bg-white text-sm md:text-base">
                <thead>
                <tr class="bg-gray-50">
                    <th class="border px-4 py-2 text-center text-lg">Code de promotion</th>
                    <th class="border px-4 py-2 text-center text-lg">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($promotions as $promotion)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $promotion->promotion_code }}</td>
                        <td class="border px-4 py-2 flex gap-2 justify-center">
                            <a href="{{ route('promotion.edit', $promotion->id) }}" class="btn btn-primary btn-sm">
                                Modifier
                            </a>
                            <button class="btn btn-error btn-sm" onclick="document.getElementById('modal-{{ $promotion->id }}').showModal()">
                                Retirer
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $promotions->links() }}
        </div>
    </div>
@endsection
