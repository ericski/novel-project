<?php

use App\Models\Project;
use App\Models\ProjectUpdate;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Component;

new class extends Component {
    public $project;
    public $count;
    public $date;
    public $type = 'session';

    protected $rules = [
        'count' => 'required|integer',
        'date' => 'required|date',
        'type' => 'required|in:session,total',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->date = now()->format('Y-m-d');
    }

    public function update()
    {
        $this->validate([
            'count' => 'required|integer',
            'date' => 'required|date',
            'type' => 'required|in:session,total',
        ]);

        $existing = ProjectUpdate::where('project_id', $this->project->id)
            ->where('date', $this->date)
            ->first();

        // If the type is total, subtract the existing count from the new count
        if ($this->type == 'total') {
            $this->count = $this->count - ($this->project->completed ?? 0);
        }

        if ($existing) {
            $existing->update([
                'count' => $existing->count + $this->count,
            ]);
        } else {
            ProjectUpdate::create([
                'project_id' => $this->project->id,
                'count' => $this->count,
                'date' => $this->date,
            ]);
        }

        // Emit an event to update the graph and progress bar
        $overall = $this->project->getChartData();
        $this->dispatch('updateGraph', [
            'count' => $existing ? $existing->count + $this->count : $this->count,
            'date' => $this->date,
            'percent' => $this->project->progress,
            'labels' => $overall['labels'],
            'progress' => $overall['progress'],
            'daily' => $this->project->getChartData('daily')['progress'],
        ]);

        // Reset form fields
        $this->reset(['count']);
    }

}; ?>

<div>
    <form wire:submit="update">
        <input type="hidden" name="project_id" value="{{ $project->id }}">

        <div class="grid sm:grid-cols-3 gap-6">
            <div class="p-6">
                <x-input-label for="count" value="{{ ucfirst($project->type) }}"/>
                <x-text-input id="count" class="block mt-1 w-full" type="text" wire:model.defer="count" required
                              autofocus/>
                <x-input-error :messages="$errors->get('count')" class="mt-2"/>
                <div class="mt-6">
                    <x-submit-button value="{{ __('Add Update') }}"/>
                </div>
            </div>

            <div class="p-6">
                <x-input-label for="type" value="{{ __('Type') }}"/>
                <x-select-dropdown wire:model="type" :options="['session' => 'Session', 'total' => 'Total']" />
                <x-input-error :messages="$errors->get('type')" class="mt-2"/>
            </div>

            <div class="p-6">
                <x-input-label for="date" value="{{ __('Date') }}"/>
                <x-text-input id="date" class="block mt-1 w-full" type="date" wire:model.defer="date" required/>
                <x-input-error :messages="$errors->get('date')" class="mt-2"/>
            </div>
        </div>
    </form>
</div>

@script
<script>
    $wire.on('updateGraph', (data) => {
        const update = data[0];
        // Update progress bar (if on show page)
        let wrapper = document.getElementById('progress-bar');
        if(wrapper) {
            // Set the "title" attribute of the first child
            wrapper.firstChild.setAttribute('title', update.percent + '%');
            let progressBar = document.getElementById('progress-bar').querySelector('.bg-blue-600');
            progressBar.style.width = update.percent + '%';
        }

        // Update the charts here
        pchart_overallChart.data.labels = update.labels;
        pchart_overallChart.data.datasets[0].data = update.progress;
        pchart_overallChart.update();

        pchart_dailyChart.data.labels = update.labels;
        pchart_dailyChart.data.datasets[0].data = update.daily;
        pchart_dailyChart.update();


    });
</script>
@endscript
