<?php
// Create a form for creating a project update
?>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
<form action="{{route('projects.updates.store', $project) }}" method="POST">
    @csrf
    <input type="hidden" name="project_id" value="{{ $project->id }}">

    <!-- create a two column layout -->
    <div class="grid sm:grid-cols-2 gap-6">

        <div class="p-6">
            <x-input-label for="count" value="{{ ucfirst($project->type) }}" />
            <x-text-input id="count" class="block mt-1 w-full" type="text" name="title" :value="old('count')" required autofocus />
            <x-input-error :messages="$errors->get('count')" class="mt-2" />
            <div class="mt-6">
                <x-submit-button value="{{ __('Add Update') }}" />
            </div>
        </div>

        <div class="p-6">
            <x-input-label for="description" value="{{ __('Date') }}" />
            <div id="datepicker-inline" inline-datepicker data-date="{{ date('m/d/Y') }}"></div>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

    </div>


</form>
