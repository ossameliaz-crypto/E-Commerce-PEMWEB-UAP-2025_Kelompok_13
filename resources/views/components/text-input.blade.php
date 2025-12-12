@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => '
        w-full 
        px-5 py-3 
        bg-gray-50 
        border border-gray-300 
        rounded-xl 
        text-gray-900 
        shadow-sm 
        focus:border-orange-500 
        focus:ring-2 
        focus:ring-orange-500 
        outline-none
    '
]) !!}>