<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modifier la candidature</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Modifier une candidature</h2>

        <form>
            <!-- Champ Nom de l'étudiant -->
            <div class="mb-4">
                <label for="student_name" class="block text-sm font-medium text-gray-700">Nom de l'étudiant</label>
                <input type="text" name="student_name" id="student_name" class="input input-bordered w-full" value="{{ $apply->student_name }}" required>
            </div>

            <!-- Champ Nom de l'entreprise -->
            <div class="mb-4">
                <label for="company_name" class="block text-sm font-medium text-gray-700">Nom de l'entreprise</label>
                <input type="text" name="company_name" id="company_name" class="input input-bordered w-full" value="{{ $apply->company_name }}" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">Modifier</button>
                <a href="{{ url('dashboard?table=apply') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</body>

</html>
