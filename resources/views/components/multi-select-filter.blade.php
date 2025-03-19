<div class="form-control w-full mb-4">
    <label class="label">
        <span class="label-text">{{ $label }}</span>
    </label>
    <select class="js-select2 select select-bordered w-full"
            name="{{ $name }}"
            {{ $multiple ? 'multiple="multiple"' : '' }}
            data-selected="{{ request()->has($name) ? request($name) : $default }}">

        @foreach ($items as $item)
            <option value="{{ $item->{$key} }}"
                {{ (request()->has($name) && request($name) == $item->{$key}) || (!request()->has($name) && $default == $item->{$key}) ? 'selected' : '' }}>
                {{ $item->{$key} }}
            </option>
        @endforeach
    </select>
</div>
