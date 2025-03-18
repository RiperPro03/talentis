<div class="form-control w-full mb-4">
    <label class="label">
        <span class="label-text">{{ $label }}</span>
    </label>
    <select class="js-select2 select select-bordered w-full" name="{{ $name }}{{ $multiple ? '[]' : '' }}" {{ $multiple ? 'multiple="multiple"' : '' }}>
        @foreach ($items as $item)
            <option value="{{ $item->{$key} }}"
                {{ in_array($item->{$key}, request($name, [])) ? 'selected' : '' }}>
                {{ $item->{$key} }}
            </option>
        @endforeach
    </select>
</div>
