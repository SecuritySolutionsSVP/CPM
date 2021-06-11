<x-layout>
    @section('title')
        {{ trans('Credentials') }}
    @stop
    @section('header')
        <h1 class="text-center">{{ trans('All') }} {{ trans('Credentials') }}</h1>
    @stop

    <livewire:password-overview :credentials="$credentials"/>
</x-layout>