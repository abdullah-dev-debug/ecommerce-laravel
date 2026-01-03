@props([
    'width' => 300,
    'height' => 300,
    'alt' => '',
    'path' => null,
    'containerClasss' => '',
])

<div class="fp-wrapper {{ $containerClasss }}">
    <div class="fp-preview-wrap row g-3"></div>

    <div class="fp-placeholder {{ $path ? 'fp-hidden' : '' }}">
        <img
            src="{{ $path ?? "https://placehold.co/{$width}x{$height}" }}"
            width="{{ $width }}"
            height="{{ $height }}"
            alt="{{ $alt }}"
            class="img-fluid"
        >
    </div>
</div>
