
    <li class="flex justify-between gap-x-6 py-5">
        <div class="flex min-w-0 gap-x-4">
            <div @class(['relative', 'filter grayscale blur-sm' => $user->censored])>
                <img class="h-12 w-12 flex-none rounded-full bg-gray-800" src="{{ $user->avatar }}" alt="">
                @if(isset($user->pivot) && $user->pivot->pinned)
                    <div class="absolute -top-1 -right-1 bg-yellow-400 rounded-full p-1" title="Pinned">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 text-gray-900">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                    </div>
                @endif
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

