@extends('layouts.app')

@section('title', 'Modifier la Promotion')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-4xl w-full bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6">Modifier la promotion</h2>

            @if (session('success'))
                <div class="bg-green-500 text-white p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('promotions.update', $promotion) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-medium">Code de la promotion</label>
                    <input type="text" name="promotion_code" value="{{ old('promotion_code', $promotion->promotion_code) }}" class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                    @error('promotion_code') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
@endsection
