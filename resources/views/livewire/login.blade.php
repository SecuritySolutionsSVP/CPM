<div>
    <div class="login">
        <img class="logo" src="/images/logo-25.svg">
    <form wire:submit.prevent="checkCredentialsAndSendEmailToken(Object.fromEntries(new FormData($event.target)))" class="login__form">
        <div class="email">
            <label for="email">{{ trans('Email Address') }}</label>
            <input type="text" name="email" value="{{App\Models\User::first()->email}}">
        </div>
        <div class="password">
            <label for="password">{{ trans('Password') }}</label>
            <input type="password" name="password">
        </div>
        {{-- <div class="remember_me">
            <label for="remember_me">{{ trans('Remember me') }}</label>
            <input type="checkbox" name="remember">
        </div> --}}
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
            <form wire:submit.prevent="authenticate(Object.fromEntries(new FormData($event.target)))">
                <input type="text" name="token" placeholder="{{ trans('2FA code from email') }}">
                <button>{{ trans('Validate') }}</button>
            </form>
        </div>
    </div>
    <div class="password-modal__overlay" wire:click="$set('showModal', false)">
    </div>
    @endif
</div>