<x-app-layout>
    <x-slot name="header">
        {{ $user->name }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <div class="flex">
                            <div class="mb-6">
                                <div @class(['relative', 'filter grayscale blur' => $user->censored])>
                                    <img class="max-w-md w-full object-cover mb-3" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                </div>
                                <!-- two column layout for buttons -->
                                <div class="flex justify-between">
                                    @if($user->id !== Auth::user()->id)
                                        <div class="follow mr-1">
                                            <livewire:profile.follow-button user="{{$user->id}}" />
                                        </div>
                                    @endif
                                    <div class="flag">
                                        @livewire('flags.flag-button', ['model' => $user])
                                    </div>
                                </div>
                            </div>
                            <div class="ml-3 p-4 flex-1">

                                @if($user->bio)
                                    <div>
                                        <h2>About</h2>
                                        <div class="bio">{{ $user->bio }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <div class="flex">
                            <div class="ml-3 p-4 flex-1">
                                <h2>Currently working on</h2>
                                <div class="mt-2">
                                    @if($user->currentProject())
                                        @include('projects.list', ['project' => $user->currentProject()])
                                    @else
                                        <div>No active project</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-3">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <div class="flex">
                            <div class="ml-3 p-4 flex-1">
                                <h2>Older Projects</h2>
                                <div class="mt-2">
                                    @if($user->olderProjects()->count() > 0)
                                        @each('projects.list', $user->olderProjects(), 'project')
                                    @else
                                        <div>No projects yet.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
