
@section('title')
    Login
@stop

<div class="login">
    <img class="logo" src="{{ env('BRANDING_IMAGE_PATH', '')}}">
    {{ Form::open(['url' => 'login', 'class' => 'login__form']) }}
    <p>
        {{ Form::label('email', trans('Email Address')) }}
        {{ Form::text('email', App\Models\User::first()->email) }}
    </p>

    <p>
        {{ Form::label('password', trans('Password')) }}
        {{ Form::password('password') }}
    </p>
    <p class="login__remember">
        {{ Form::label('Remember me', trans('Remember me')) }}
        {{ Form::checkbox('Remember me') }}
    </p>

    <p>{{ Form::submit(trans('Login')) }}</p>
    {{ Form::close() }}
</div>
