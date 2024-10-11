<!-- livewire/follow-button.blade.php -->
<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public $project;
    public $isJoined;
    public $eid;

    public function mount($eid, $project)
    {
        $this->project = $project;
        $this->eid = $eid;
        $this->isJoined = isset($project->event_id);
    }

    public function toggleJoin()
    {
        if ($this->isJoined) {
            $this->project->update(['event_id' => null]);
        } else {
            $this->project->update(['event_id' => $this->eid]);
        }

        // Toggle the following status
        $this->isJoined = !$this->isJoined;

        // Emit an event to update the button text
        $this->dispatch('joinToggled', $this->isJoined);

    }
}
?>
<div>
    <x-primary-button id="join-button" wire:click="toggleJoin">
        @if ($isJoined)
            Leave Current Event
        @else
            Join Current Event
        @endif
    </x-primary-button>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('joinToggled', isJoined => {
            const button = document.getElementById('join-button');
            if (isJoined) {
                button.innerText = 'Leave Current Event';
            } else {
                button.innerText = 'Join Current Event';
            }
        });
    });
</script>
