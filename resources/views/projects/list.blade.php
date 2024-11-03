
    <li class="flex justify-between gap-x-6 py-5">
        <div class="flex min-w-0 gap-x-4">
            <div @class(['relative', 'filter grayscale blur-sm' => $project->censored])>
                <img class="h-18 w-12 flex-none rounded-sm bg-gray-800" src="{{ $project->cover }}" alt="{{ $project->title }}">
            </div>
            <div class="min-w-0 flex-auto">
                <p class="text-sm font-semibold leading-6 text-gray-400 dark:text-white"><a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a> by <a href="{{ route('people.show', $project->author->profile) }}">{{ $project->author->name }}</a></p>
                <p class="mt-1 truncate text-xs leading-5 text-gray-400">Goal: {{ $project->goal }} {{ $project->type }}.</p>
            </div>
        </div>

        <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end w-28 gap-y-2">
            <x-status-badge :status="$project->status" />
            <x-progress-bar :progress="$project->progress" />
        </div>
    </li>

