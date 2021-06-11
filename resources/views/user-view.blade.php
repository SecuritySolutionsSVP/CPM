<x-layout>
    @section('title')
        {{ trans('Users') }}
    @stop
    @section('header')
        <h1 class="text-center">{{ trans('All') }} {{ trans('Users') }}</h1>
    @stop
    <livewire:user-overview :users="$users"/>
</x-layout>