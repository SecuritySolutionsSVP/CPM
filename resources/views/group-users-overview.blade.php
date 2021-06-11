<x-layout>
    @section('title')
        {{ trans('Users') }}
    @stop
    @section('header')
        <h1 class="text-align-center">{{ trans('Group') }} {{ trans('Users') }}</h1>
    @stop

    <livewire:group-users-overview :users="$users" :groupID="$groupID" />
</x-layout>