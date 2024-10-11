<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $event->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-3">This event will run from {{ $event->start_date->format('M j, Y') }} to {{ $event->end_date->format('M j, Y') }}
                    </div>
                    <div>
                        {{ $event->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <h2>Projects signed up for this event</h2>
                        <ul role="list" class="divide-y divide-gray-800">
                            @each('projects.list', $event->projects, 'project')
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
