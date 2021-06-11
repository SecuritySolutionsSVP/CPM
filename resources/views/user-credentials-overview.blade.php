<x-layout>
    @section('title')
        {{ trans('Credentials') }}
    @stop
    @section('header')
        <h1 class="text-align-center">{{ trans('User') }} {{ trans('Credentials') }}</h1>
    @stop

    <livewire:user-credentials-overview :credentials="$credentials" :userID="$userID" />
</x-layout>