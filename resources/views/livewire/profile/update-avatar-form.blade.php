<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public $avatar;

    public function updateAvatar(): void
    {
        try {
            $validated = $this->validate([
                'avatar' => ['required', 'image'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('avatar');

            throw $e;
        }

        $path = $validated['avatar']->store('avatars', 'public');
        Auth::user()->update([
            'avatar' => Storage::url($path),
        ]);
        Auth::user()->refresh();

        // Reset the avatar input.
        $this->reset('avatar');

        // Emit an event to update the avatar in the UI.
        $this->dispatch('avatar-updated', Auth::user()->avatar);

    }
}
?>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Avatar') }}
        </h2>
    </header>

    <form wire:submit="updateAvatar" class="mt-6 space-y-6">
        <img id="user-avatar" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
             class="rounded-full h-20 w-20 object-cover">
        <input type="file" wire:model="avatar" id="avatar" name="avatar" class="my-2 block"/>
        <x-input-error :messages="$errors->get('avatar')" class="mt-2"/>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update') }}</x-primary-button>

            <x-action-message class="me-3" on="avatar-updated">
                {{ __('Avatar Updated.') }}
            </x-action-message>
        </div>
    </form>
</section>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('avatar-updated', avatarUrl => {
            const img = document.getElementById('user-avatar');
            img.src = avatarUrl;
        });
    });
</script>
