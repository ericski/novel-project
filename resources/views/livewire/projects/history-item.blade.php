<?php

use App\Models\ProjectUpdate;
use Illuminate\Support\Facades\Gate;
use Livewire\Volt\Component;

new class extends Component {
    public ProjectUpdate $update;
    public bool $editing = false;
    public bool $deleted = false;
    public string $editDate;
    public int $editCount;

    public function mount(ProjectUpdate $update)
    {
        $this->update = $update;
        $this->editDate = $update->date->format('Y-m-d');
        $this->editCount = $update->count;
    }

    public function startEdit()
    {
        // Check authorization
        if (!Gate::allows('update', $this->update->project)) {
            abort(403);
        }

        $this->editing = true;
        $this->editDate = $this->update->date->format('Y-m-d');
        $this->editCount = $this->update->count;
    }

    public function cancelEdit()
    {
        $this->editing = false;
        $this->editDate = $this->update->date->format('Y-m-d');
        $this->editCount = $this->update->count;
    }

    public function save()
    {
        // Check authorization
        if (!Gate::allows('update', $this->update->project)) {
            abort(403);
        }

        $this->validate([
            'editDate' => 'required|date',
            'editCount' => 'required|integer|min:1',
        ]);

        $this->update->update([
            'date' => $this->editDate,
            'count' => $this->editCount,
        ]);

        $this->editing = false;

        // Dispatch event to notify parent that update was saved
        $this->dispatch('update-saved');
    }

    public function delete()
    {
        // Check authorization
        if (!Gate::allows('update', $this->update->project)) {
            abort(403);
        }

        $updateId = $this->update->id;
        $this->update->delete();

        // Dispatch browser event to trigger Alpine.js to hide the row
        $this->dispatch('row-deleted-' . $updateId);
    }
}; ?>

<tr
    x-data="{ showDeleteModal: false, isDeleted: false }"
    x-show="!isDeleted"
    x-on:row-deleted-{{ $update->id }}.window="isDeleted = true"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    @if($editing)
        <!-- Edit Mode -->
        <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0 dark:text-white">
            <x-text-input
                type="date"
                wire:model="editDate"
                class="block w-full"
            />
            <x-input-error :messages="$errors->get('editDate')" class="mt-1" />
        </td>
        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
            <x-text-input
                type="number"
                wire:model="editCount"
                class="block w-full"
                min="1"
            />
            <x-input-error :messages="$errors->get('editCount')" class="mt-1" />
        </td>
        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
            <button
                wire:click="save"
                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3"
            >
                Save
            </button>
            <button
                wire:click="cancelEdit"
                class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300"
            >
                Cancel
            </button>
        </td>
    @else
        <!-- View Mode -->
        <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0 dark:text-white">
            {{ $update->date->format('M j, Y') }}
        </td>
        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
            {{ $update->count }}
        </td>
        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
            <button
                wire:click="startEdit"
                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3"
            >
                Edit
            </button>
            <button
                @click="showDeleteModal = true"
                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
            >
                Delete
            </button>
        </td>
    @endif

    <!-- Delete Confirmation Modal - Teleported to body -->
    @teleport('body')
        <div
            x-show="showDeleteModal"
            x-cloak
            class="relative z-50"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
            style="display: none;"
        >
            <!-- Background backdrop -->
            <div
                x-show="showDeleteModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-500/75 transition-opacity dark:bg-gray-900/50"
            ></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!-- Modal panel -->
                    <div
                        x-show="showDeleteModal"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg dark:bg-gray-800 dark:outline dark:outline-1 dark:-outline-offset-1 dark:outline-white/10"
                    >
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 dark:bg-gray-800">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10 dark:bg-red-500/10">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6 text-red-600 dark:text-red-400" aria-hidden="true">
                                        <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-white" id="modal-title">Delete Update Entry</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Are you sure you want to delete this update entry from {{ $update->date->format('M j, Y') }} with a count of {{ $update->count }}? This action cannot be undone.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 dark:bg-gray-700/25">
                            <button
                                type="button"
                                wire:click="delete"
                                @click="showDeleteModal = false"
                                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto dark:bg-red-500 dark:shadow-none dark:hover:bg-red-400"
                            >
                                Delete
                            </button>
                            <button
                                type="button"
                                @click="showDeleteModal = false"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto dark:bg-white/10 dark:text-white dark:shadow-none dark:ring-white/5 dark:hover:bg-white/20"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endteleport
</tr>

