
<div class="mt-4">
    <!-- Dropdown menu on small screens -->
    <div class="sm:hidden">
        <label for="current-tab" class="sr-only">Select a tab</label>
        <select id="current-tab" name="current-tab" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600" onchange="window.location.href=this.value;">
            @foreach($tabs as $tab)
                <option value="{{ $tab['url'] }}" {{ $active === $tab['title'] ? 'selected' : '' }}>{{ $tab['title'] }}</option>
            @endforeach
        </select>
    </div>
    <!-- Tabs at small breakpoint and up -->
    <div class="hidden sm:block">
        <nav class="-mb-px flex space-x-8">
            @foreach($tabs as $tab)
                <a href="{{ $tab['url'] }}" class="{{ $active === $tab['title'] ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} whitespace-nowrap border-b-2 px-1 pb-4 text-sm font-medium">
                    {{ $tab['title'] }}
                </a>
            @endforeach
        </nav>
    </div>
</div>
