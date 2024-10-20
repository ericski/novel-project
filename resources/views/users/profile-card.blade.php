<div class="divide-y divide-gray-200 bg-gray-50 overflow-hidden shadow rounded-lg">
    <div class="px-4 py-5 sm:px-6 flex justify-between bg-white">
        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-200">Profile</h3>
        <x-secondary-action-button href="{{ route('profile') }}">Edit</x-secondary-action-button>
    </div>
    <div class="bg-gray-50 px-4 py-5 sm:p-6 flex flex-col items-center">
        <div class="min-w-0 flex-shrink-0 mb-3">
            <img id="user-avatar" src="{{ $user->avatar }}" alt="{{ $user->name }}"
                 class="rounded-full h-20 w-20 object-cover">
        </div>
        <div class="text-sm text-center leading-5 text-gray-500 dark:text-gray-400">
            <p class="text-base">{{ $user->name }}</p>
            <p>{{ $user->email }}</p>
        </div>
    </div>
</div>
