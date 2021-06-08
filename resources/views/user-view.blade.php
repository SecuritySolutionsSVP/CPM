<x-layout>
    @section('title')
        Users
    @stop

    <livewire:user-overview :users="$users"/>
</x-layout>