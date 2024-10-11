@props([
    'name', // Name of the radio input group
    'options' => [], // Associative array of options, 'value' => 'label'
    'currentValue' => null, // The currently selected value
])

<fieldset>
    <div class="mt-8 space-y-6 sm:flex sm:items-center sm:space-x-10 sm:space-y-0">
        @foreach($options as $value => $label)
            <div class="flex items-center">
                <input
                    id="{{ $name }}-{{ $value }}"
                    name="{{ $name }}"
                    type="radio"
                    value="{{ $value }}"
                    {{ $currentValue == $value ? 'checked' : '' }}
                    class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                <label for="{{ $name }}-{{ $value }}" class="ml-3 block text-sm font-medium leading-6 text-gray-900">
                    {{ $label }}
                </label>
            </div>
        @endforeach
    </div>
</fieldset>
