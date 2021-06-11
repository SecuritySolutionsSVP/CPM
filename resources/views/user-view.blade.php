<x-layout>
    @section('title')
        {{ trans('Users') }}
    @stop
    @section('header')
        <h1 class="text-align-center">{{ trans('All') }} {{ trans('Users') }}</h1>
    @stop
    <livewire:user-overview :users="$users"/>
</x-layout>