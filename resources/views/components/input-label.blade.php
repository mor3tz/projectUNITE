@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold  text-white']) }}>
    {{ $value ?? $slot }}
</label>
