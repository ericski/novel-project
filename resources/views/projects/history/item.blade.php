<tr>
    <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0 dark:text-white">{{ $update->date->format('M j, Y') }}</td>
    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $update->count }}</td>
    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
        <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
        <a href="#" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</a>
    </td>
</tr>
