<div class="password-list">
    <div class="password-list__list">
        @foreach ($credentials as $credential)
            <div class="password-list__list__item clearfix">
                <div class="password-list__list__item__name">
                    Password for {{ $credential->credentialGroup->name }}
                </div>
                <div class="password-list__list__item__created">
                    <a href="#">{{ $credential->created_at->diffForHumans() }}</a>
                </div>
                <div class="password-list__list__item__icons">
                    <i class="fas fa-user password-list__list__item__icons__get-username"></i>
                    <i class="fas fa-key password-list__list__item__icons__get-password"></i>
                    <i class="fas fa-cogs password-list__list__item__icons__open-settings"></i>
                </div>
            </div>
        @endforeach

    </div>
</div>

<div class="password-list__modal">
    <h2> Password for Web server</h2>
    <div class="password-list__modal__credentials">
        {{ Form::label('username', 'Username') }}
        <div>
            {{ Form::text('username') }} <i class="fas fa-copy"></i>
        </div>
        {{ Form::label('password', 'Password') }}
        <div>
            {{ Form::password('password') }} <i class="fas fa-copy"></i> <i class="fas fa-eye"></i> <i class="fas fa-eye-slash"></i>
        </div>
    </div>
    <div class="password-list__modal__accesslog">
        {{-- Could also be used as a access / changelog if you had the right credentials to see changes --}}
        @for ($i = 0; $i < 5; $i++)
        <div>
            Test-user accessed password at 09:35 - 26/05/2021
        </div>
        @endfor
    </div>
    <div>
        <a class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" href="#">See more...</a>
    </div>
</div>

<div class="password-list__modal__overlay">
</div>
