@props([  
    'name',   
    'id',
    'label' => 'Label',   
    'options' => [],   
    'selected' => null,   
    'placeholder' => '-- Select Option --',   
    'class' => '',   
    'attr' => null,  
    'isRequired' => true,
])  

<div class="form-group">  
    <label for="{{ $name }}">{{ $label }}</label> @if($isRequired) <span class="text-danger">*</span>@endif
    <select   
        name="{{ $name }}"   
        id="{{ $id }}"   
        class="form-control {{ $class }}"   
        {{ $attr }}   
    >  
        <option value="" disabled selected>{{ $placeholder }}</option>  
        @foreach ($options as $value => $label)  
            <option   
                value="{{ $value }}"   
                {{ $selected == $value ? 'selected' : '' }}  
            >{{ $label }}</option>  
        @endforeach  
    </select>
</div>