<div>
    <div class="login">
        <img class="logo" src="/images/logo-25.svg">
    <form wire:submit.prevent="submit" method="POST" class="login__form">
        <div class="email">
            <label for="email">{{ trans('Email Address') }} - {{ $email }}</label>
            <input type="text" wire:model="email">
        </div>
        <div class="password">
            <label for="password">{{ trans('Password') }}</label>
            <input type="password" wire:model="password">
        </div>
        <div class="remember_me">
            <label for="remember_me">{{ trans('Remember me') }}</label>
            <input type="checkbox" wire:model="remember">
        </div>
        <div class="submit">
            <input type="submit" value="{{ trans('Login') }}" />
        </div>
    </form>
    </div>
    @if ($showModal)
    <div class="password-modal">
        <div class="text-right">
            <i class="fas fa-times fa-2x cursor-pointer" wire:click="$set('showModal', false)"></i>
        </div>
        <div>
            content
        </div>
    </div>
    <div class="password-modal__overlay" wire:click="$set('showModal', false)">
    </div>
    @endif
</div>
