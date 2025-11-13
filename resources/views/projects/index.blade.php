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
            <!-- Sort Controls -->
            <div class="mb-4 flex justify-end">
                <div class="inline-flex rounded-md shadow-sm" role="group">
                    @php
                        $currentParams = request()->all();
                        $newDirection = ($sortBy === 'percent_complete' && $sortDirection === 'desc') ? 'asc' : 'desc';
                        $sortParams = array_merge($currentParams, ['sort' => 'percent_complete', 'direction' => $newDirection]);

                        // Create tooltip text
                        if ($sortBy === 'percent_complete') {
                            $tooltipText = $sortDirection === 'desc'
                                ? 'Currently: High to Low. Click to sort Low to High'
                                : 'Currently: Low to High. Click to sort High to Low';
                        } else {
                            $tooltipText = 'Click to sort by % Complete (High to Low)';
                        }
                    @endphp
                    <a href="{{ route('projects.index', $sortParams) }}"
                       title="{{ $tooltipText }}"
                       class="px-4 py-2 text-sm font-medium {{ $sortBy === 'percent_complete' ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700' }} border border-gray-200 dark:border-gray-700 rounded-lg focus:z-10 focus:ring-2 focus:ring-indigo-500">
                        Sort by % Complete
                        @if($sortBy === 'percent_complete')
                            @if($sortDirection === 'desc')
                                <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @else
                                <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            @endif
                        @endif
                    </a>
                </div>
            </div>

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
