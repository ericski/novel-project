<x-app-layout>
    <x-slot name="header">
        Create a Project
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @include('projects._form', ['project' => new App\Models\Project()])
            </div>
        </div>
    </div>
</x-app-layout>
