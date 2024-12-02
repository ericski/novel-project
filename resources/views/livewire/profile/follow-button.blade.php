<!-- livewire/follow-button.blade.php -->
<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public $user;
    public $isFollowing;

    public function mount($user)
    {
        $this->user = $user;
        $this->isFollowing = Auth::user()->following->contains($this->user);
    }

    public function toggleFollow()
    {
        if ($this->isFollowing) {
            Auth::user()->following()->detach($this->user);
        } else {
            Auth::user()->following()->attach($this->user);
        }

        // Toggle the following status
        $this->isFollowing = !$this->isFollowing;

        // Emit an event to update the button text
        $this->dispatch('followingToggled', $this->isFollowing);

    }
}
?>
<div>
    <x-primary-button id="follow-button" wire:click="toggleFollow">
        @if ($isFollowing)
            Unfollow
        @else
            Follow
        @endif
    </x-primary-button>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('followingToggled', isFollowing => {
            const button = document.getElementById('follow-button');
            if (isFollowing) {
                button.innerText = 'Unfollow';
            } else {
                button.innerText = ' Follow ';
            }
        });
    });
</script>
