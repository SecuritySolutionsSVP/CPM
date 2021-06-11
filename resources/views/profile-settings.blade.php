<x-layout>
    @section('title')
        {{ trans('User') }}
    @stop
    @section('header')
        <h1 class="text-center">{{ trans('All') }} {{ trans('User') }}</h1>
    @stop
    <livewire:profile-settings :user="$user"/>
</x-layout>