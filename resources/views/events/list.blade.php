<li class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow">
    <div class="flex w-full items-center justify-between space-x-6 p-6">
        <div class="flex-1 truncate">
            <div class="flex items-center space-x-3">
                <h3 class="truncate text-sm font-medium text-gray-900"><a href="{{ route('events.show', $event->slug) }}" >{{ $event->name }}</a></h3>
                <span class="inline-flex flex-shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">{{ $event->projects()->count() }}</span>

            </div>
            <p class="mt-1 truncate text-sm text-gray-500">{{ $event->description }}</p>
        </div>
    </div>
    <div>
        <div class="-mt-px flex divide-x divide-gray-200">
            <div class="flex w-0 flex-1">
                <span class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900">{{ $event->start_date->format('M j, Y') }}</span>
            </div>
            <div class="-ml-px flex w-0 flex-1">
                <span class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900">{{ $event->end_date->format('M j, Y') }}</span>
            </div>
        </div>
    </div>
</li>
