@php
    $color = match ($status) {
        'pending' => 'yellow',
        'in progress' => 'blue',
        'abandoned' => 'red',
        'complete' => 'green',
        default => 'gray',
    };
@endphp

<div
    class="inline-flex flex-shrink-0 items-center rounded-full bg-{{ $color }}-50 px-1.5 py-0.5 text-xs font-medium text-{{ $color }}-700 ring-1 ring-inset ring-{{ $color }}-600/20">
    {{ $status }}
</div>
