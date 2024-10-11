@php
    $tabs = [
        ['title' => 'Mine', 'url' => route('projects.index')],
        ['title' => 'Friends', 'url' => route('projects.index', ['friends' => 'true'])],
        ['title' => 'All', 'url' => route('projects.index', ['all' => 'true'])],
    ];
@endphp

<x-app-layout :tabs="$tabs" :active="$active">
    <x-slot name="header">
        {{ __('Projects') }}
    </x-slot>

    <x-slot name="actions">
        <x-action-button :href="route('projects.create')">{{ __('Add') }}</x-action-button>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <ul role="list" class="divide-y divide-gray-800">
                        @each('projects.list', $projects, 'project')
                    </ul>
                </div>

            </div>
        </div>
        @if($projects->hasPages())
            <div class="max-w-7xl mx-auto mt-3 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
