<div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-gray-50 shadow row-span-2 sm:col-span-2 lg:col-span-3">
    <div class="px-4 py-5 sm:px-6 flex justify-between bg-white">
        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-200">Following</h3>
        <x-secondary-action-button href="{{ route('people.index', ['friends' => 'true']) }}">View all</x-secondary-action-button>
    </div>
    <div class="bg-gray-50 px-4 py-5 sm:p-6">
        <div class="text-sm leading-5 text-gray-500 dark:text-gray-400">
            <ul role="list" class="divide-y divide-gray-800">
                @each('users.list', $users, 'user')
            </ul>
        </div>
    </div>
</div>
