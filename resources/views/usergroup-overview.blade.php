<x-layout>
    @section('title')
        {{ trans('Groups') }}
    @stop
    @section('header')
        <h1 class="text-center">{{ trans('All') }} {{ trans('Groups') }}</h1>
    @stop
    <livewire:group-overview :groups="$groups" />
</x-layout>