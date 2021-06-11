<div>
    <div class="group-overview">
        <div>
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" wire:click="addCredentialModal()">{{ trans('Add Credentials') }}</button>
            <a href="/users" ><button
                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">{{ trans('Back') }}</button></a>
            <input type="text" class="searchbar" wire:model.debounce.500ms="searchString" placeholder="{{trans('Search')}}">
        </div>
            
        <div class="group-overview__list">
            @foreach ($shownCredentials->sortBy('username') as $credential)
            <div class="group-overview__list__item clearfix">
                <div class="group-overview__list__item__name">
                    {{ $credential->username }} {{ trans('Passwords for') }} {{ $credential->credentialGroup->name }}
                </div>
                <div class="group-overview__list__item__icons">
                    <i class="fas fa-key group-overview__list__item__icons__get-delete" wire:click="removeCredential({{$credential->id}})" onclick="confirm('{{ trans('Are you sure you want to remove this credential?') }}') || event.stopImmediatePropagation()"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @if ($addModal)
        <div class="group-modal">
            <div class="text-right">
                <i class="fas fa-times fa-2x cursor-pointer" wire:click="$set('addModal', false)"></i>
            </div>
            <div>
                <h2> {{ trans('User Credential') }}</h2>
                <div class="group-modal__name">
                    {{ Form::label('Credentials', trans('Credentials')) }}
                    <input type="text" class="searchbar" wire:model.debounce.500ms="addCredentialSearchString" placeholder="{{trans('Search')}}">
                    <div>
                        @foreach ($shownNoneCredentials->sortBy('username') as $noneCredential)
                            <div class="group-overview__list__item clearfix">
                                <div class="group-overview__list__item__name">
                                    {{ $noneCredential->username }} {{ trans('Passwords for') }} {{ $noneCredential->credentialGroup->name }}
                                </div>
                                <div class="group-overview__list__item__icons">
                                    <i class="fas fa-key group-overview__list__item__icons__get-users" wire:click="addCredential({{$noneCredential->id}})"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="group-modal__overlay" wire:click="$set('addModal', false)"> </div>        
    @endif
</div>
