<?php
// Create a form for creating or updating a project, use components for the form fields
?>
<form action="{{ $project->exists ? route('projects.update', $project) : route('projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($project->exists)
        @method('PUT')
    @endif

    <!-- create a two column layout -->
    <div class="grid sm:grid-cols-2 gap-6">
        <div>
            <div class="p-6">
                <x-input-label for="title" value="{{ __('Title') }}" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $project->title)" required autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="p-6">
                <x-input-label for="description" value="{{ __('Description') }}" />
                <x-textarea-input id="description" class="block mt-1 w-full" name="description" :value="old('description', $project->description)" required />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
        </div>

        <div>
            <div class="p-6">
                <label class="block text-sm leading-5 font-medium text-gray-700 mb-2">
                    Cover Photo
                </label>
                <div class="">
                    <div id="image-wrapper" class="img-wrapper mr-4 mb-3">
                        @if($project->exists() && $project->cover)
                            <img class="max-w-md w-full object-cover" src="{{ $project->cover }}" alt="{{ $project->title }}">
                        @else
                            <svg height="200px" width="140px" id="placeholder" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000" stroke="#000000"><g id="SVGRepo_iconCarrier"> <path style="fill:#bdbdbd;" d="M403.2,405.333H62.578v2.64c17.95,6.346,30.815,23.458,30.815,43.583l0,0 c0,20.123-12.864,37.235-30.815,43.583v2.64H403.2c25.527,0,46.222-20.695,46.222-46.222l0,0 C449.422,426.028,428.727,405.333,403.2,405.333z"></path> <path style="fill:#000000;" d="M358.4,0H62.578c-7.855,0-14.222,6.369-14.222,14.222v335.171c0,7.854,6.367,14.222,14.222,14.222 S76.8,357.247,76.8,349.393V28.444h281.6c42.348,0,76.8,34.453,76.8,76.8v295.067c-9.287-5.821-20.254-9.2-32-9.2H62.578 c-7.855,0-14.222,6.369-14.222,14.222v2.64c0,6.027,3.799,11.401,9.482,13.409c12.76,4.511,21.333,16.637,21.333,30.174 s-8.573,25.663-21.333,30.174c-5.683,2.008-9.482,7.38-9.482,13.409v2.64c0,7.854,6.367,14.222,14.222,14.222H403.2 c33.33,0,60.444-27.115,60.444-60.444V105.244C463.644,47.212,416.432,0,358.4,0z M403.2,483.556H98.426 c5.87-9.395,9.189-20.423,9.189-32s-3.318-22.605-9.189-32H403.2c17.646,0,32,14.356,32,32S420.846,483.556,403.2,483.556z"></path> </g></svg>
                        @endif
                    </div>
                    <div>
                        <input type="file" name="cover">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="p-6">
        <div class="grid sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="goal" value="{{ __('Goal') }}" />
                <x-text-input id="goal" class="block mt-1 w-full" type="text" name="goal" :value="old('goal', $project->goal)" />
                <x-input-error :messages="$errors->get('goal')" class="mt-2" />
            </div>

            <div>
                <x-radio-select
                    name="goal_type"
                    :options="['1' => 'Words', '0' => 'Days']"
                    current-value="{{ old('goal_type', $project->exists ? ($project->goal_type ? 1 : 0) : 1) }}"
                />
                <x-input-error :messages="$errors->get('goal_type')" class="mt-2" />
            </div>
        </div>
    </div>

    @if ($project->exists)
        <div class="p-6">
            <x-input-label for="status" value="{{ __('Status') }}" />
            <x-select-dropdown
                name="status"
                :options="['pending', 'in progress', 'shelved', 'abandoned', 'complete']"
                current-value="{{ old('status', $project->status) }}"
            />
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <div class="p-6">
            <x-input-label for="active" value="{{ __('Active') }}" />
            <x-toggle-switch name="active" :starting-value="old('active', $project->active)">
                {{ __('Active Project') }}
            </x-toggle-switch>
            <x-input-error :messages="$errors->get('active')" class="mt-2" />
        </div>

    @endif

    <div class="p-6">
        <x-submit-button value="{{ $project->exists ? __('Update') : __('Create') }}" />
    </div>
</form>
