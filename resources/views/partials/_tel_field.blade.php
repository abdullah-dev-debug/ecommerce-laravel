@php
    $name  = $name  ?? 'phone';
    $label = $label ?? 'Phone';
    $id    = $id    ?? $name;
    $value = old($name, $value ?? '');
@endphp

<div class="fm-group">
    <label for="{{ $id }}">{{ $label }}</label>

    <input
        type="tel"
        name="{{ $name }}"
        id="{{ $id }}"
        class="form-control phone-input"
        value="{{ $value }}"
        placeholder="Enter {{ $label }}"
    >
</div>
