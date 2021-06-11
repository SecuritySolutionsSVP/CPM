<x-layout>
    @section('title')
        {{ trans('Dashboard') }}
    @stop
    @section('header')
        <h1 class="text-center">{{ trans('My') }} {{ trans('Credentials') }}</h1>
    @stop
    <livewire:password-overview :credentials="$credentials">
</x-layout>