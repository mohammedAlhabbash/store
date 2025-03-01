@props(['name', 'checked' => false, 'label' => false, 'options'])
@if ($label)
    <label for="">{{ $label }}</label>
@endif
@foreach ($options as $key => $labelName)
    <div class="form-check">
        <input type="radio" name="{{ $name }}" @checked((old($name) ?? $checked) == $key) value="{{ $key }}"
            {{ $attributes->class(['form-check-input', 'is-invalid' => $errors->has($name)]) }}>
        <label class="form-check-label">
            {{ $labelName }}
        </label>
    </div>
@endforeach
