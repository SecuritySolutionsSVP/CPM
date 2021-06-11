<div>
    <p>{{ trans('Hello, your users password just got reset, please go to ') }} <a href="{{ env('APP_URL')}}/login">{{ trans('Login') }}</a></p>
    <p>{{ trans('Your new password is') }}: {{ $password }}</p>
</div>