@props(['type' => 'sukses', 'message' => null])

@php
    $warna = match ($type) {
        'error', 'gagal' => 'background:#4a1c24; border-color:#dc3545; color:#ffd6db;',
        default          => 'background:#0f3d33; border-color:#64ffda; color:#d6fff4;',
    };
@endphp

<div {{ $attributes->merge(['style' => "padding:12px 16px; margin-bottom:16px; border-radius:6px; border:1px solid; {$warna}"]) }}>
    {{ $slot->isEmpty() ? $message : $slot }}
</div>
