@extends('layouts.app')

@section('title', 'Modifier l\'addresse')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-10 flex flex-col items-center">

            <h2 class="text-2xl font-bold mb-6">Modifier l'addresse</h2>

            @if (session('success'))
                <div class="bg-green-500 text-white p-2 rounded mb-4">
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

            <form action="{{ route('address.update', $address) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-medium">Code Postal</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code) }}" class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-medium">Code Postal</label>
                    <input type="text" name="city" value="{{ old('city', $address->city) }}" class="w-full p-2 border-gray-300 rounded-lg bg-gray-100 focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Enregistrer</button>
                </div>
            </form>
        </div>

    <a href= "{{route('address.index')}}" class="btn btn-secondary w-fit mx-auto mt-4 px-6 py-2 flex items-center justify-center">
        ← Retour
    </a>
@endsection
