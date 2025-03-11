@props(['item'])

<tr class="border-b">
    @foreach ((array) $item as $key => $value)
        @if ($key !== 'created_at' && $key !== 'updated_at')
            <td class="px-4 py-2 text-center sm:text-left">{{ $value }}</td>
        @endif
    @endforeach
    <td class="flex justify-center gap-2 py-2">
        <div class="flex flex-wrap gap-2 w-full justify-center">
            <!-- Bouton Modifier avec lien vers la page d'édition -->
            <x-table-row :item="$item" :table="'pilot'" />
            
            <button class="btn btn-error btn-sm w-full sm:w-auto">✖ Supprimer</button>
        </div>
    </td>
</tr>
