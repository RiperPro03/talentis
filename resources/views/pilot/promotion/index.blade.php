@extends('layouts.app')

@section('title', 'Wish-list d\'Offres')

@section('content')
    <div class="container mx-auto py-6 px-4">
        {{--        <!-- Bouton de retour -->--}}
        {{--        <div class="flex justify-start mb-4">--}}
        {{--            <a href="{{ url()->previous() }}" class="btn btn-secondary">← Retour</a>--}}
        {{--        </div>--}}

        @if ($errors->any())
            <div class="alert alert-error shadow-lg mb-4">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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


        <h1 class="text-lg md:text-4xl font-bold mb-6 text-center">Les étudiants</h1>



        <!-- Version Mobile: Affichage en cartes -->
    </div>


    <div class="md:hidden flex flex-col gap-4">
        @foreach ($promotions as $promotion)
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold">{{ $promotion->promotion_code }}</h2>

                <!-- Actions -->
                <div class="mt-3 flex justify-between">
                    {{--                    <a href="{{ route('offer.show', $offer) }}" class="btn btn-primary btn-sm">Voir</a>--}}
                    {{--                    <form action="{{ route('wishlist.remove', $offer) }}" method="POST">--}}
                    {{--                        @csrf--}}
                    {{--                        @method('DELETE')--}}
                    <button class="btn btn-error btn-sm">Retirer</button>
                    {{--                    </form>--}}
                </div>
            </div>
        @endforeach
    </div>

    <!-- Version Desktop: Affichage en tableau -->
    <div class="hidden md:block overflow-x-auto">
        <table class="table w-full border-collapse border bg-white text-sm md:text-base">
            <thead>
            <tr class="bg-gray-50">
                <th class="border px-4 py-2 text-center text-lg">Code de promotion</th>
                <th class="border px-4 py-2 text-center text-lg">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($promotions as $promotion)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $promotion->promotion_code }}</td>

                    <td class="border px-4 py-2 flex gap-2 justify-center">
                        {{--                        <a href="{{ route('offer.show', $offer) }}" class="btn btn-sm btn-primary">Voir</a>--}}
                        {{--                        //<form action="{{ route('wishlist.remove', $offer) }}" method="POST">--}}
                        {{--                            //@csrf--}}
                        {{--                            //@method('DELETE')--}}
                        <button class="btn btn-sm btn-error">Retirer</button>
                        {{--                        </form>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


@endsection
