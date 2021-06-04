<x-layout>
    @section('title')
        Passwords
    @stop

    <livewire:password-overview :credentials="$credentials"/>
    {{-- <x-password-overview :credentials="$credentials">
        
    </x-password-list> --}}
</x-layout>