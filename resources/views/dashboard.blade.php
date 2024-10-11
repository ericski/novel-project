<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (Auth::user()->projects->count())
                <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow">
                    <div class="px-4 py-5 sm:px-6 flex justify-between">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-200">Active Project</h3>
                        <x-status-badge :status="Auth::user()->currentProject()->status" />
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:p-6">
                        <div class="text-sm leading-5 text-gray-500 dark:text-gray-400">
                            @include('projects.card', ['project' => Auth::user()->currentProject()])
                        </div>
                    </div>
                </div>
            @else
                <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-200">No active projects</h3>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:p-6">
                        <div class="text-sm leading-5 text-gray-500 dark:text-gray-400">
                            <p><a href="{{ route('projects.create') }}" class="text-blue-600">Create a new project</a> to get started.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
