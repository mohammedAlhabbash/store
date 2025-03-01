 @props(['name', 'options' => null, 'label' => false, 'defualtName'=>null, 'value', 'parents'])

 @if ($label)
     <label for="">{{ $label }}</label>
 @endif
 <select name="{{$name}}" class="form-control">
     <option value="">{{ $defualtName }}</option>
     @foreach ($parents as $parent)
         <option value="{{ $parent->id }}" @selected($parent->id == (old($name) ?? $value))>{{ $parent->name }}</option>
     @endforeach
 </select>
