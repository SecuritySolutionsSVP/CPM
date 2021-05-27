
@section('title')
    Login
@stop
<div class="login">
    <img class="logo" src="/images/logo-25.svg">
    {{ Form::open(['url' => 'login', 'class' => 'login__form']) }}
    <p>
        {{ Form::label('email', 'Email Address') }}
        {{ Form::text('email') }}
    </p>

    <p>
        {{ Form::label('password', 'Password') }}
        {{ Form::password('password') }}
    </p>
    <p class="login__remember">
        {{ Form::label('Remember me', 'Remember me') }}
        {{ Form::checkbox('Remember me') }}
    </p>

    <p>{{ Form::submit('Login') }}</p>
    {{ Form::close() }}
</div>
