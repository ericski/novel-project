<!-- livewire/follow-button.blade.php -->
<?php

use App\Models\Flag;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public $model;
    public $isFlagged;

    public function mount($model)
    {
        $this->model = $model;
        $this->isFlagged = Flag::where('user_id', Auth::id())->where('flaggable_id', $model->id)->where('flaggable_type', $model::class)->exists();
    }

    public function toggleFlag()
    {
        if ($this->isFlagged) {
            Flag::where('user_id', Auth::id())->where('flaggable_id', $this->model->id)->where('flaggable_type', $this->model::class)->delete();
        } else {
            Flag::create([
                'user_id' => Auth::id(),
                'flaggable_id' => $this->model->id,
                'flaggable_type' => $this->model::class,
            ])->save();
        }

        // Toggle the flagged status
        $this->isFlagged = !$this->isFlagged;

        // Emit an event to update the button text
        $this->dispatch('flagToggled', $this->isFlagged);

    }
}
?>
<div>
    <x-primary-button id="flag-button" title="{{ $isFlagged ? 'You have flagged this image as inappropriate, you can click this button again to un-flag the image' : 'Flag this image as inappropriate' }}" wire:click="toggleFlag">
        @if ($isFlagged)
            <svg style="height:17px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                 class="size-6">
                <path fill-rule="evenodd"
                      d="M3 2.25a.75.75 0 0 1 .75.75v.54l1.838-.46a9.75 9.75 0 0 1 6.725.738l.108.054A8.25 8.25 0 0 0 18 4.524l3.11-.732a.75.75 0 0 1 .917.81 47.784 47.784 0 0 0 .005 10.337.75.75 0 0 1-.574.812l-3.114.733a9.75 9.75 0 0 1-6.594-.77l-.108-.054a8.25 8.25 0 0 0-5.69-.625l-2.202.55V21a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 3 2.25Z"
                      clip-rule="evenodd"/>
            </svg>

        @else
            <svg style="height:17px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/>
            </svg>
        @endif
    </x-primary-button>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('flagToggled', isFlagged => {
            const button = document.getElementById('flag-button');
            if (isFlagged) {
                button.innerHTML = '<svg style="height:17px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 1 .75.75v.54l1.838-.46a9.75 9.75 0 0 1 6.725.738l.108.054A8.25 8.25 0 0 0 18 4.524l3.11-.732a.75.75 0 0 1 .917.81 47.784 47.784 0 0 0 .005 10.337.75.75 0 0 1-.574.812l-3.114.733a9.75 9.75 0 0 1-6.594-.77l-.108-.054a8.25 8.25 0 0 0-5.69-.625l-2.202.55V21a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 3 2.25Z" clip-rule="evenodd" /> </svg>';
            } else {
                button.innerHTML = '<svg style="height:17px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" /></svg>';
            }
        });
    });
</script>
