<div>
    <div class="password-list">
        <p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded mb-3" wire:click="displayCredentialCreateModal()">{{ trans('Create new Password') }}</button>
        </p> 
        <div class="password-list__list">
            @foreach ($credentials as $credential)
                <div class="password-list__list__item clearfix">
                    <div class="password-list__list__item__name">
                        {{ $credential->username }} {{ trans('Passwords for') }} {{ $credential->credentialGroup->name }}
                    </div>
                    <div class="password-list__list__item__created">
                        {{ $credential->created_at->diffForHumans() }}
                    </div>
                    <div class="password-list__list__item__icons">
                        <i class="fas fa-user password-list__list__item__icons__get-username" wire:click="displayCredentialAccessModal({{$credential->id}})"></i>
                        <i class="fas fa-key password-list__list__item__icons__get-password" wire:click="displayCredentialEditModal({{$credential->id}})"></i>
                        <i class="fas fa-trash password-list__list__item__icons__get-delete" wire:click="deleteCredential({{$credential->id}})" onclick="confirm('{{ trans('Are you sure you want to remove this credential?')}}') || event.stopImmediatePropagation()"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @if ($showModal && $selectedCredential)
        <div class="password-modal">
            <div class="text-right">
                <i class="fas fa-times fa-2x cursor-pointer" wire:click="hideAllModals()"></i>
            </div>
            <div>
                <h2> {{ trans('Passwords for') }} {{ $selectedCredential->username}}</h2>
                <div class="password-modal__credentials">
                    {{ Form::label('username', trans('Username')) }}
                    <div>
                        {{ Form::text('username') }} <i class="fas fa-copy"></i>
                    </div>
                    {{ Form::label('password', trans('Password')) }}
                    <div>
                        {{ Form::password('password') }} 
                        <i class="fas fa-copy" title="{{ trans('Copy') }}"></i> 
                        <i class="fas fa-eye"></i>
                        <i class="fas fa-eye-slash"></i>
                    </div>
                </div>
                <div class="password-modal__accesslog">
                    @foreach ($selectedCredential->credentialAccessLogs->sortBy('created_at')->reverse() as $credLog)
                        <div>
                            {{ trans('password seen') }} {{ Timezone::convertToLocal($credLog->created_at) }} {{ trans('by') }} {{ $credLog->user->fullName() }} {{-- 09:35 - 26/05/2021 --}}
                        </div>
                    @endforeach
                </div>
                {{-- <div class="mb-12">
                    <a class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                        href="#">{{ trans('See more...') }}</a>
                </div> --}}
                <div>
                    <button
                        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">{{ trans('Cancel') }}</button>
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">{{ trans('Save') }}</button>
                </div>
            </div>
        </div>
        <div class="password-modal__overlay" wire:click="hideAllModals()">
        </div>
    @elseif ($editModal)
    <div class="password-modal">
        <div class="text-right">
            <i class="fas fa-times fa-2x cursor-pointer" wire:click="hideAllModals()"></i>
        </div>
        <div>
            <form wire:submit.prevent="editPassword(Object.fromEntries(new FormData($event.target)))">
                <h1> {{ trans('Change password') }} </h2>
                <div class="password-modal__credentials">
                    <p>{{ trans('Disclaimer: Only change this after you\'ve changed the password locally') }}</p>
                    <p>{{ trans('Asset') }}: {{ $selectedCredential->credentialGroup->name }}
                    <p>{{ trans('Username') }}: {{ $selectedCredential->username }}</p>
                    <label for="password">{{ trans('Password') }}</label>
                    <div>
                        <input type="password" name="password" placeholder="{{ trans('New password')}}">
                    </div>
                </div>
                <div>
                    <button type="button" wire:click="hideAllModals()"
                        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">{{ trans('Cancel') }}</button>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">{{ trans('Save') }}</button>
                </div>
            </form>
            @if ($success)
                <div class="text-green-700">
                    {{ trans('Successfully changed to new password!') }}
                </div>
            @endif
        </div>
    </div>
    <div class="password-modal__overlay" wire:click="hideAllModals()"></div>
    @elseif ($createModal)
    <div class="password-modal">
        <div class="text-right">
            <i class="fas fa-times fa-2x cursor-pointer" wire:click="hideAllModals()"></i>
        </div>
        <div>
            <form wire:submit.prevent="createCredential(Object.fromEntries(new FormData($event.target)))">
                <h2> {{ trans('Create new credential') }}</h2>
                <div class="password-modal__credentials">
                    <label for="asset">{{ trans('Asset') }}</label>
                    <div>
                        <div>
                            {{-- <label for="newCredentialGroup">{{ trans('Use existing or create new asset') }}</label> --}}
                            <div>
                                <input type="radio" name="newCredentialGroup" id="newCredentialGroup_1" wire:model="shouldCreateNewCredentialGroup" wire:key="yes" value="true" /> 
                                <label for="newCredentialGroup_1">{{ trans('New asset') }}</label><br>
                                <input type="radio" name="newCredentialGroup" id="newCredentialGroup_2" wire:model="shouldCreateNewCredentialGroup" wire:key="no" value="false" checked/> 
                                <label for="newCredentialGroup_2">{{ trans('Existing asset') }}</label>
                            </div>
                            <div>
                                @if (filter_var($shouldCreateNewCredentialGroup, FILTER_VALIDATE_BOOLEAN))
                                <label for="asset">{{ trans('New asset') }}</label>
                                <div>
                                    <input x-show="false" type="text" name="asset">
                                </div>
                                @else
                                <label for="asset">{{ trans('Select existing asset') }}</label>
                                <div>
                                    <select name="asset">
                                        @foreach(App\Models\CredentialGroup::all() as $key => $cGroup)
                                        <option value="{{$cGroup->name}}" wire:key="{{ $key }}">{{ $cGroup->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <label for="username">{{ trans('Username') }}</label>
                    <div>
                        <input type="text" name="username">
                    </div>
                    <label for="password">{{ trans('Password') }}</label>
                    <div>
                        <input type="password" name="password">
                    </div>
                    <label for="is_sensitive">{{ trans('Mark as sensitive') }}</label>
                    <input type="checkbox" name="is_sensitive" id="is_sensitive">
                </div>
                <div>
                    <button type="button" wire:click="hideAllModals()"
                        class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">{{ trans('Cancel') }}</button>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">{{ trans('Create') }}</button>
                </div>
                @if ($success)
                    <div class="text-green-700">
                        {{ trans('Successfully created new credential') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
    <div class="password-modal__overlay" wire:click="hideAllModals()"></div>
    @endif
    @if ($refreshPage)
        <script>
            location.reload();
        </script>
    @endif
</div>
