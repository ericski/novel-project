<form action="{{route('discord.store') }}" method="POST">
    @csrf
    <x-submit-button value="{{ __('Request Invite') }}" />
</form>
