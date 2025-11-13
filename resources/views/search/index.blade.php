@php
    $tabs = [
        ['title' => 'Users', 'url' => route('search.index', ['q' => $query])],
        ['title' => 'Projects', 'url' => route('search.index', ['q' => $query, 'projects' => 'true'])],
    ];
@endphp

<x-app-layout :tabs="$tabs" :active="$active">
    <x-slot name="header">
        {{ __('Search Results') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($query)
                <div class="mb-4 text-gray-900 dark:text-gray-100">
                    <p class="text-sm">Showing results for: <strong>{{ $query }}</strong></p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($active === 'Users')
                        @if($users->count() > 0)
                            <ul role="list" class="divide-y divide-gray-800">
                                @each('users.list', $users, 'user')
                            </ul>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No users found.</p>
                        @endif
                    @else
                        @if($projects->count() > 0)
                            <ul role="list" class="divide-y divide-gray-800">
                                @each('projects.list', $projects, 'project')
                            </ul>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No projects found.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        @if($active === 'Users' && $users->hasPages())
            <div class="max-w-7xl mx-auto mt-3 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        @endif

        @if($active === 'Projects' && $projects->hasPages())
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

