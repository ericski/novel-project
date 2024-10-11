<x-app-layout>
    <x-slot name="header">
        Edit {{ $project->title }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @include('projects._form', ['project' => $project])
            </div>
        </div>
    </div>
</x-app-layout>
