<div class="w-full relative flex flex-col gap-2">
    <!-- Label -->
    @if ($label)
        <label for="{{ $name }}" class="text-sm font-semibold text-gray-700">{{ $label }}</label>
    @endif

    <!-- Champ de saisie avec icône (si applicable) -->
    <div class="relative w-full">
        @if ($type === 'select')
            <select name="{{ $name }}" id="{{ $name }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $class }}">
                @foreach ($options as $key => $option)
                    <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
        @elseif ($type === 'textarea')
            <textarea name="{{ $name }}" id="{{ $name }}" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $class }}" placeholder="{{ $placeholder }}">{{ old($name, $value) }}</textarea>
        @else
            <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}"
                   class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $class }}"
                   placeholder="{{ $placeholder }}">
            @if ($type === 'email')
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8.5L9.942 10.239C11.657 11.254 12.343 11.254 14.058 10.239L17 8.5"></path>
                    <path stroke-linejoin="round" stroke-width="1.5" d="M2 13.475C2.081 16.541 2.114 18.074 3.245 19.209C4.376 20.345 5.95 20.384 9.099 20.463C11.039 20.512 12.961 20.512 14.901 20.463C18.05 20.384 19.624 20.345 20.755 19.209C21.886 18.074 21.919 16.541 21.984 13.475C22.005 12.49 22.005 11.51 21.984 10.524C21.919 7.459 21.886 5.926 20.755 4.791C19.624 3.655 18.05 3.616 14.901 3.537C12.961 3.488 11.039 3.488 9.099 3.537C5.95 3.616 4.376 3.655 3.245 4.791C2.114 5.926 2.081 7.459 2.016 10.524C1.995 11.51 1.995 12.49 2.016 13.475Z"></path>
                </svg>
            @endif
        @endif
    </div>

    <!-- Gestion des erreurs -->
    @error($name)
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>
