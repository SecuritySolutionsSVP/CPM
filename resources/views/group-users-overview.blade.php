<x-layout>
    @section('title')
        Users
    @stop

    <livewire:group-users-overview :users="$users" :groupID="$groupID" />
</x-layout>