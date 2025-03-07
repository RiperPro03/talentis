<div class="form-control w-full">
    <label class="label">
        <span class="text-lg font-semibold text-neutral">{{ $question }}</span>
    </label>

    @foreach ($answers as $index => $answer)
        <input type="{{ Str::contains(strtolower($question), 'mot de passe') ? 'password' : 'text' }}"
            name="{{ Str::slug($question) }}[]" class="input input-bordered w-full mb-2"
            placeholder="{{ Str::contains(strtolower($question), 'mot de passe')
                ? 'Saisissez votre mot de passe'
                : (Str::contains(strtolower($question), 'adresse e-mail')
                    ? 'Saisissez votre adresse e-mail'
                    : 'Saisissez une réponse') }}">
    @endforeach
</div>
