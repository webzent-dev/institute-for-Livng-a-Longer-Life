@props(['class' => ''])
<select {{ $attributes->merge(['class' => 'w-full border rounded-md py-2 px-3 ' . $class]) }}>
    {{ $slot }}
</select>
