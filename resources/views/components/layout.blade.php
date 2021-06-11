<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="/css/app.css" rel="stylesheet">
    <livewire:styles />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    <script src="/js/app.js"></script>
    <title>{{ env('APP_NAME', 'CPM') }} - @yield('title')</title>
</head>

<body>
    <div class="header">
        <div class="md:container md:mx-auto">
            <a href="/"><img class="logo" src="{{ env('BRANDING_IMAGE_PATH', '')}}"></a>
            <div class="header__navigation hidden md:inline-block">
                <div class="header__navigation__item"><a href="/">{{ trans('Dashboard') }}</a></div>
                @if(Auth::check() && (Auth::user()->role_id == 1 || Auth::user()->role_id == 2))
                <div class="header__navigation__item"><a href="/users">{{ trans('Users') }}</a></div>
                <div class="header__navigation__item"><a href="/credentials">{{ trans('Credentials') }}</a></div>
                @endif
                <div class="header__navigation__item"><a href="/groups">{{ trans('Groups') }}</a></div>
                @if(Auth::check())
                <div class="header__navigation__item"><a href="/logout">{{ trans('Logout') }}</a></div>
                @else
                    <div class="header__navigation__item"><a href="/login">{{ trans('Login') }}</a></div>
                @endif
            </div>
            <div class="inline-block md:hidden float-right">
                <i class="header__show-mobile fas fa-bars fa-2x hidden"></i>
            </div>
        </div>
    </div>
    <div class="mobile-header">
        <div class="text-right p-5">
            <i class="fas fa-times fa-2x cursor-pointer" wire:click="$set('showModal', false)"></i>
        </div>   
            <div class="mobile-header__navigation">
                <div class="mobile-header__navigation__item"><a href="/">{{ trans('Dashboard') }}</a></div>
                @if (Auth::check())
                    <div class="mobile-header__navigation__item"><a href="/logout">{{ trans('Logout') }}</a></div>
                @else
                    <div class="mobile-header__navigation__item"><a href="/login">{{ trans('Login') }}</a></div>
                @endif
            </div>
    </div>
    <div class="md:container md:mx-auto">
        {{ $slot }}
    </div>

    <livewire:scripts />
</body>

</html>
