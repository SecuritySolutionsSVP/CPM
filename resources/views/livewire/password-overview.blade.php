<div>
    <div class="password-list">
        <div class="password-list__list">
            @for ($i = 0; $i < 10; $i++)
                <div class="password-list__list__item clearfix">
                    <div class="password-list__list__item__name" wire:click="$set('showModal', true)">
                        Password for Web server {{ $i + 1 }}
                    </div>
                    <div class="password-list__list__item__created">
                        <a href="#">09:35 - 26/05/2021</a>
                    </div>
                    <div class="password-list__list__item__icons">
                        <i class="fas fa-user password-list__list__item__icons__get-username"></i>
                        <i class="fas fa-key password-list__list__item__icons__get-password"></i>
                        <i class="fas fa-cogs password-list__list__item__icons__open-settings"></i>
                    </div>
                </div>
            @endfor
    
        </div>
    </div>
    @if ($showModal)
        <div class="password-modal">
            <div class="text-right">
                <i class="fas fa-times fa-2x cursor-pointer" wire:click="$set('showModal', false)"></i>
            </div>
            <div>
                <h2> Password for Web server</h2>
                <div class="password-modal__credentials">
                    {{ Form::label('username', 'Username') }}
                    <div>
                        {{ Form::text('username') }} <i class="fas fa-copy"></i>
                    </div>
                    {{ Form::label('password', 'Password') }}
                    <div>
                        {{ Form::password('password') }} <i class="fas fa-copy"></i> <i class="fas fa-eye"></i> <i
                            class="fas fa-eye-slash"></i>
                    </div>
                </div>
                <div class="password-modal__accesslog">
                    {{-- Could also be used as a access / changelog if you had the right credentials to see changes --}}
                    @for ($i = 0; $i < 5; $i++)
                        <div>
                            Test-user accessed password at 09:35 - 26/05/2021
                        </div>
                    @endfor
                </div>
                <div class="mb-12">
                    <a class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                        href="#">See more...</a>
                </div>
                <div>
                    <button
                        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Cancel</button>
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">Save</button>
                </div>
            </div>
        </div>
        <div class="password-modal__overlay" wire:click="$set('showModal', false)">
        </div>
    @endif

</div>