<x-layout>
    @section('title')
        {{ trans('Profile') }}
    @stop
    @section('header')
        <h1 class="text-center">{{ trans('Profile') }}</h1>
    @stop
    <livewire:profile-settings :user="$user"/>
</x-layout>