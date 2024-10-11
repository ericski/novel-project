@php
    $tabs = [
        ['title' => 'All', 'url' => route('people.index')],
        ['title' => 'Friends', 'url' => route('people.index', ['friends' => 'true'])],
    ];
@endphp

<x-app-layout :tabs="$tabs" :active="$active">
    <x-slot name="header">
        {{ __('Users') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <ul role="list" class="divide-y divide-gray-800">
                        @each('users.list', $users, 'user')
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @if($users->hasPages())
        <div class="max-w-7xl mx-auto mt-3 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
