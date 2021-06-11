<div>
    <div class="group-overview">
        <div>
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" wire:click="addUserModal()">{{ trans('Add User') }}</button>
            <a href="/groups" ><button
                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">{{ trans('Back') }}</button></a>
            <input type="text" class="searchbar" wire:model.debounce.500ms="searchString" placeholder="{{trans('Search')}}">
        </div>
            
        <div class="group-overview__list">
            @foreach ($shownUsers->sortBy('email') as $user)
            <div class="group-overview__list__item clearfix">
                <div class="group-overview__list__item__name">
                    {{ $user->email }}
                </div>
                <div class="group-overview__list__item__icons">
                    <i class="fas fa-user-times group-overview__list__item__icons__get-delete" wire:click="removeUser({{$user->id}})" onclick="confirm('Are you sure you want to remove this User?') || event.stopImmediatePropagation()"></i>
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
                <h2> {{ trans('Group settings') }}</h2>
                <div class="group-modal__name">
                    {{ Form::label('Users', trans('Users')) }}
                    <input type="text" class="searchbar" wire:model.debounce.500ms="addUserSearchString" placeholder="{{trans('Search')}}">
                    <div>
                        @foreach ($shownNoneUsers->sortBy('email') as $userx)
                            <div class="group-overview__list__item clearfix">
                                <div class="group-overview__list__item__name">
                                    {{ $userx->email }}
                                </div>
                                <div class="group-overview__list__item__icons">
                                    <i class="fas fa-user-plus group-overview__list__item__icons__get-users" wire:click="addUser({{$userx->id}})"></i>
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
