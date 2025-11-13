<div class="divide-y divide-gray-200 bg-gray-50 overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:px-6 flex justify-between bg-white">
        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-200">Active Event</h3>
        <x-secondary-action-button href="{{ route('events.index') }}">View All</x-secondary-action-button>
    </div>
    <div class="bg-gray-50 px-4 py-5 sm:p-6 flex flex-col items-center">
        @if($active)
            <div class="text-sm text-center leading-5 text-gray-500 dark:text-gray-400">
                <p class="text-base">{{ $active->name }}</p>
                <p>{{ $active->start_date->format('M j, Y') }} - {{ $active->end_date->format('M j, Y') }}</p>
            </div>
            <div class="mt-3">
                <a href="{{ route('events.show', $active->slug) }}" class="text-blue-600">View Event</a>
            </div>
            <div class="mt-2">
                @livewire('projects.join-button', ['eid' => $active->id, 'project' => $project])
            </div>
        @else
            <div class="text-sm text-center leading-5 text-gray-500 dark:text-gray-400">
                <p>No active event</p>
            </div>
        @endif
    </div>
</div>
