<x-layout>
    @section('title')
        {{ trans('Passwords') }}
    @stop
    @section('header')
        <h1 class="text-align-center">{{ trans('All') }} {{ trans('Passwords') }}</h1>
    @stop

    <livewire:password-overview :credentials="$credentials"/>
</x-layout>