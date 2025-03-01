@props(['value' => '', 'label' => false, 'name'])
@if ($label)
    <label for="">{{ $label }}</label>
@endif
<textarea name="{{ $name }}" cols="30" rows="10" @class(['form-control', 'is-invalid' => $errors->has($name)])>{{ old($name) ?? $value }}</textarea>
@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
