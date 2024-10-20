<div class="min-w-0 gap-x-4">
    <div @class(['relative mb-3', 'filter grayscale blur-sm' => $project->censored])>
        <img class="h-20 w-20 flex-none rounded-sm bg-gray-800" src="{{ $project->cover }}" alt="{{ $project->title }}">
    </div>
    <div class="min-w-0">
        <p class="text-sm font-semibold leading-6 text-gray-400 dark:text-white"><a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a></p>
        <p class="my-2 truncate text-xs leading-5 text-gray-400">Goal: {{ $project->goal }} {{ $project->type }}.</p>
        <x-progress-bar :progress="$project->progress" />
    </div>
</div>


