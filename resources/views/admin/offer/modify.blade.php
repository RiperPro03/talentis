<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier les données de l'offre</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Modifier une offre</h2>

        <form>
            <!-- Champ Titre de l'offre -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Titre de l'offre</label>
                <input type="text" name="title" id="title" class="input input-bordered w-full" value="{{ $offer->title }}" required>
            </div>

            <!-- Champ Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="input input-bordered w-full" required>{{ $offer->description }}</textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">Modifier</button>
                <a href="{{ url('dashboard?table=offer') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</body>

</html>
