<x-layout>
    @section('title')
        Passwords
    @stop

    <livewire:password-overview :credentials="$credentials"/>
</x-layout>