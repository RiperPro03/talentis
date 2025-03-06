@props(['item'])

<tr>
    @foreach((array) $item as $key => $value)
        @if($key !== 'created_at' && $key !== 'updated_at')
            <td class="border p-2">{{ $value }}</td>
        @endif
    @endforeach
    <td class="flex gap-2">
        <button class="btn btn-warning btn-sm">🛠 Modifier</button>
        <button class="btn btn-error btn-sm">✖ Supprimer</button>
    </td>
</tr>