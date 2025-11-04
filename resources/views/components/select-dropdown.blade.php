@props([
    'name' => null,                 // optional, only if you also do classic form posts
    'options' => [],                // ['value' => 'Label'] or ['session','total']
    'currentValue' => '',           // used only when NO wire:model* is provided
    'placeholder' => 'Select an option',
])

@php
    // detect wire:model*, capture prop name and modifier
    $wireModelAttr = collect(['wire:model', 'wire:model.defer', 'wire:model.lazy'])
        ->first(fn ($a) => $attributes->has($a));
    $wireProp = $wireModelAttr ? $attributes->get($wireModelAttr) : null;
    $wireModifier = match ($wireModelAttr) {
        'wire:model.defer' => '.defer',
        'wire:model.lazy'  => '.lazy',
        default            => '',
    };

    // don’t forward wire:model* to the wrapper (prevents double-binding loops)
    $cleanAttrs = $attributes->except(['wire:model', 'wire:model.defer', 'wire:model.lazy']);

    // normalize options => ['value' => 'Label']
    $normalized = [];
    foreach ($options as $k => $v) {
        if (is_int($k)) { $normalized[$v] = ucfirst($v); }
        else            { $normalized[$k] = $v; }
    }
@endphp

<div
    {{ $cleanAttrs->merge(['class' => 'relative mt-2']) }}
    x-data="{
        open: false,
        selected: null,
        choose(v) {
            this.selected = v;
            // push the change to Livewire by firing an input event on the hidden input
            this.$refs.hidden.value = v;
            this.$refs.hidden.dispatchEvent(new InputEvent('input', { bubbles: true }));
            this.open = false;
        },
    }"
    x-init="
        @if($wireProp)
            // seed from Livewire
            selected = @this.get('{{ $wireProp }}')
        @else
            // or from provided default
            selected = @js($currentValue)
        @endif
    "
>
    {{-- Hidden input: the ONLY Livewire binding lives here --}}
    <input
        type="hidden"
        x-ref="hidden"
        x-bind:value="selected"
        @if($wireProp) wire:model{{ $wireModifier }}="{{ $wireProp }}" @endif
        @if($name) name="{{ $name }}" @endif
    >

    {{-- Button --}}
    <button
        type="button"
        @click="open = !open"
        class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
        aria-haspopup="listbox"
        :aria-expanded="open.toString()"
    >
        <span class="block truncate" x-text="selected || '{{ $placeholder }}'"></span>
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd" />
            </svg>
        </span>
    </button>

    {{-- Options --}}
    <ul
        x-show="open"
        x-transition
        @click.outside="open = false"
        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
        role="listbox"
    >
        @foreach ($normalized as $value => $label)
            <li
                @click="choose(@js($value))"
                class="text-gray-900 relative cursor-default select-none py-2 pl-8 pr-4 hover:bg-indigo-600 hover:text-white"
            >
                <span
                    class="block truncate"
                    :class="{ 'font-semibold': selected === @js($value), 'font-normal': selected !== @js($value) }"
                    x-text="@js($label)"
                ></span>

                <span
                    class="absolute inset-y-0 left-0 flex items-center pl-1.5"
                    :class="{ 'text-indigo-600': selected === @js($value), 'hidden': selected !== @js($value) }"
                >
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                </span>
            </li>
        @endforeach
    </ul>
</div>
