@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:ring-black-500 focus:ring-black-500 rounded-md shadow-md px-1 py-1']) !!}>
