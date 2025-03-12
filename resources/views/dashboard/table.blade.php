@extends('layouts.dashboard-admin')

@section('title', 'Tableau de bord - Talentis')

@section('content')
    <div class="container mx-auto px-4">
        <div class="card bg-white shadow-xl">
            <div class="card-body">
                <div class="flex items-center justify-between">
                    <h3 class="card-title text-2xl font-bold text-gray-800">
                        📋 Données de la table : <span class="text-primary">{{ ucfirst($table) }}</span>
                    </h3>
                    <a href="{{ route("admin.$table.create") }}" class="btn btn-primary">
                        ➕ Ajouter une donnée
                    </a>
                </div>

                @if ($items->isEmpty())
                    <p class="text-center text-gray-500 mt-4">
                        Aucune donnée disponible dans la table {{ $table }}.
                    </p>
                @else
                    <div class="overflow-x-auto mt-4">
                        <table class="table table-zebra w-full">
                            <!-- Head -->
                            <thead>
                            <tr>
                                @foreach(array_keys($items->first()->getAttributes()) as $column)
                                    <th>{{ ucfirst($column) }}</th>
                                @endforeach
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <!-- Body -->
                            <tbody>
                            @foreach($items as $item)
                                <tr>
                                    @foreach($item->getAttributes() as $key => $value)
                                        <td>
                                            @if($key === 'description' || $key === 'logo_path')
                                                {{ Str::limit($value, 10) }}
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="flex justify-center space-x-2">
                                        <a href="{{ route("admin.$table.edit", $item->id) }}" class="btn btn-warning btn-sm">
                                            ✏️ Modifier
                                        </a>
                                        <form action="{{ route("admin.$table.destroy", $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error btn-sm"
                                                    onclick="return confirm('Voulez-vous vraiment supprimer cette entrée ?')">
                                                ❌ Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <!-- Optionnel: Foot -->
                            <tfoot>
                            <tr>
                                @foreach(array_keys($items->first()->getAttributes()) as $column)
                                    <th>{{ ucfirst($column) }}</th>
                                @endforeach
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="mt-4 flex justify-center">
                        {{ $items->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
