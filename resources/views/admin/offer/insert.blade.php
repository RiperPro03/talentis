<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Ajouter un nouveau produit</h2>

        <form>
            <!-- Champ Nom du produit -->
            <div class="mb-4">
                <label for="product_name" class="block text-sm font-medium text-gray-700">Nom du produit</label>
                <input type="text" name="product_name" id="product_name" class="input input-bordered w-full"
                    required>
            </div>

            <!-- Champ Prix -->
            <div class="mb-4">
                <label for="product_price" class="block text-sm font-medium text-gray-700">Prix</label>
                <input type="number" name="product_price" id="product_price" class="input input-bordered w-full"
                    required>
            </div>

            <!-- Boutons -->
            <div class="text-center">
                <button type="submit" class="btn btn-success">Ajouter</button>
                <a href="{{ url('dashboard?table=offer') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</body>

</html>
