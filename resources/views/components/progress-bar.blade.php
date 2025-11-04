@props([
  'progress' => 0,
  'width' => 'w-full',
])

<div {{ $attributes->merge(['class' => "$width bg-gray-200 rounded-full h-4"]) }} title="{{ $progress }}%">
    <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $progress }}%;"></div>
</div>
