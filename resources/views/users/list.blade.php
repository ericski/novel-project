
    <li class="flex justify-between gap-x-6 py-5">
        <div class="flex min-w-0 gap-x-4">
            <div @class(['relative', 'filter grayscale blur-sm' => $user->censored])>
                <img class="h-12 w-12 flex-none rounded-full bg-gray-800" src="{{ $user->avatar }}" alt="">
            </div>
            <div class="min-w-0 flex-auto">
                <p class="text-sm font-semibold leading-6 text-gray-400 dark:text-white"><a href="{{ route('people.show', $user->profile) }}">{{ $user->name }}</a></p>
            </div>
        </div>
        @if($user->currentProject())
            <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                <p class="text-xs font-semibold leading-6 text-gray-400 dark:text-white"><a href="{{ route('projects.show', $user->currentProject()->slug) }}">{{ $user->currentProject()->title }}</a>
                <x-progress-bar :progress="$user->currentProject()->progress" width="w-64"/>
            </div>
        @endif
    </li>

