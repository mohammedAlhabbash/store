@props(['name', 'options' => null, 'label' => false, 'defualtName'=>null, 'selected'=>null, 'parents'])
@if ($label)
    <label for="">{{ $label }}</label>
@endif
<select name="{{ $name }}"
    {{ $attributes->class(['form-control', 'form-select', 'is-invalid' => $errors->has($name)]) }}>
    @foreach ($options as $value => $text)
        <option value="{{ $value }}" @selected($value == $selected)>{{ $text }}</option>
    @endforeach
</select>
