<x-app-layout>
    <x-slot name="header">
        {{ $project->title }}
    </x-slot>

    @can('update', $project)
        <x-slot name="actions">
            <x-action-button :href="route('projects.edit', $project)">{{ __('Edit') }}</x-action-button>
        </x-slot>
    @endcan

    <div class="py-12">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <div class="flex">
                            <div class="mb-6">
                                <div @class(['relative', 'filter grayscale blur' => $project->censored])>
                                    <img class="max-w-md w-full object-cover" src="{{ $project->cover }}" alt="{{ $project->title }}">
                                </div>
                                <div class="flag mt-2">
                                    @livewire('flags.flag-button', ['model' => $project])
                                </div>
                                @can('update', $project)
                                    @if($activeEvent && ($project->event_id === $activeEvent || $project->event_id === null))
                                        <div class="mt-2">
                                            @livewire('projects.join-button', ['eid' => $activeEvent, 'project' => $project])
                                        </div>
                                    @elseif($project->event_id)
                                        <div class="mt-2">
                                            <a href="{{ route('events.show', $project->event->slug) }}" class="text-blue-600">Was part of {{ $project->event->name }}</a>
                                        </div>
                                    @endif
                                @endcan
                            </div>
                            <div class="ml-3 p-4 flex-1">
                                <div>Goal: {{ $project->goal }} {{ $project->type }}. <x-status-badge :status="$project->status" /></div>
                                <div id="progress-bar" class="mt-2 mb-2"><x-progress-bar id="project-{{$project->id}}" :progress="$project->progress" /></div>
                                <div>Author: <a class="text-blue-600" href="{{ route('people.show', $project->author->profile) }}">{{ $project->author->name }}</a></div>
                                @can('update', $project)
                                    <div class="mt-2 bg-gray-100 border-gray-300 rounded">
                                        <h2 class="text-lg font-semibold p-4 pb-1">Update Progress</h2>
                                        @livewire('projects.project-update-form', ['project' => $project])
                                    </div>
                                    <div class="mt-2 bg-gray-100 border-gray-300 rounded">
                                        <h2 class="text-lg font-semibold p-4 pb-1">Update Log</h2>
                                        <div class="px-4 pb-4">
                                            <a href="{{ route('projects.history.index', $project->id) }}" class="text-blue-600">View Log</a>
                                        </div>
                                    </div>
                                @endcan
                                <div class="mt-5">{{ $project->description }}</div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <h3 class="text-lg mb-3 text-center font-semibold">Goal Progress</h3>
                            @include('projects.progress-chart', ['chart_data' => $project->getChartData(), 'id' => 'overallChart', 'chart_type' => Auth::user()->chart_preference ?? 'line'])
                        </div>
                        <div class="mt-5">
                            <h3 class="text-lg mb-3 text-center font-semibold">Daily Progress</h3>
                            @include('projects.progress-chart', ['chart_data' => $project->getChartData('daily'), 'id' => 'dailyChart', 'chart_type' => Auth::user()->chart_preference ?? 'line'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
