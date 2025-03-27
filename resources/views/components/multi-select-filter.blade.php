<div class="form-control w-full mb-4">
    <label class="label">
        <span class="label-text">{{ $label }}</span>
    </label>
    <select class="js-select2 select select-bordered w-full"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            {{ $multiple ? 'multiple="multiple"' : '' }}
            data-selected="{{ json_encode(request()->has($name) ? (array) request($name) : (array) $default) }}">

        @foreach ($items as $item)
            @php
                $selectedValues = request()->has($name) ? (array) request($name) : (array) $default;
            @endphp
            <option value="{{ $item->{$key} }}"
                {{ in_array($item->{$key}, $selectedValues) ? 'selected' : '' }}>
                {{ $item->{$key} }}
            </option>
        @endforeach
    </select>
</div>
