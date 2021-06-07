<x-layout>
    @section('title')
        Groups
    @stop

    <livewire:group-overview :groups="$groups" />
</x-layout>