@props(['data'])

<table class="table w-full">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td class="flex gap-2">
                    <button class="btn btn-warning btn-sm">🛠 Modifier</button>
                    <button class="btn btn-error btn-sm">✖ Supprimer</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>