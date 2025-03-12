<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter une candidature</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Ajouter une candidature</h2>

        <form>
            <!-- Champ Étudiant -->
            <div class="mb-4">
                <label for="student_id" class="block text-sm font-medium text-gray-700">Sélectionner un étudiant</label>
                <select name="student_id" id="student_id" class="input input-bordered w-full" required>
                    <!-- Options dynamique à ajouter en fonction de la liste des étudiants -->
                    <option value="1">Étudiant 1</option>
                    <option value="2">Étudiant 2</option>
                </select>
            </div>

            <!-- Champ Entreprise -->
            <div class="mb-4">
                <label for="company_id" class="block text-sm font-medium text-gray-700">Sélectionner une entreprise</label>
                <select name="company_id" id="company_id" class="input input-bordered w-full" required>
                    <!-- Options dynamique à ajouter en fonction de la liste des entreprises -->
                    <option value="1">Entreprise 1</option>
                    <option value="2">Entreprise 2</option>
                </select>
            </div>

            <!-- Boutons -->
            <div class="text-center">
                <button type="submit" class="btn btn-success">Ajouter</button>
                <a href="{{ url('dashboard?table=apply') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</body>

</html>
