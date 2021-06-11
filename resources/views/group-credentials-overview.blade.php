<x-layout>
    @section('title')
        {{ trans('Credentials') }}
    @stop
    @section('header')
        <h1 class="text-align-center">{{ trans('Group') }} {{ trans('Credentials') }}</h1>
    @stop

    <livewire:group-credentials-overview :credentials="$credentials" :groupID="$groupID" />
</x-layout>