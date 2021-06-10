<div>
    <div class="group-overview">
        <div>
            <button wire:click="createGroupModal()"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded mb-3" >
                {{ trans('Create') }}
            </button>
            <input type="text" class="searchbar" wire:model.debounce.500ms="searchString" placeholder="{{trans('Search')}}">
        </div>
        <div class="group-overview__list">
            @foreach ($shownGroups->sortBy('name') as $group)
            <div class="group-overview__list__item clearfix">
                <div class="group-overview__list__item__name">
                    {{ $group->name }}
                </div>
                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                <div class="group-overview__list__item__icons">
                    <a href="/group/{{$group->id}}/users"><i class="fas fa-users group-overview__list__item__icons__get-users"></i></a>
                    <i class="fas fa-cogs group-overview__list__item__icons__open-settings" wire:click="editGroupModal({{$group->id}})"></i>
                    <i class="fas fa-trash group-overview__list__item__icons__get-delete" wire:click="deleteGroupModal({{$group->id}})" onclick="confirm('Are you sure you want to remove this group?') || event.stopImmediatePropagation()"></i>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @if ($createModal)
        <div class="group-modal">
            <div class="text-right">
                <i class="fas fa-times fa-2x cursor-pointer" wire:click="$set('createModal', false)"></i>
            </div>
            <div>
                <h2> {{ trans('Group settings') }}</h2>
                <div class="group-modal__name">
                    <form wire:submit.prevent="createGroup(Object.fromEntries(new FormData($event.target)))">
                        {{ Form::label('Group Name', trans('Group Name')) }}
                        <div>
                            {{ Form::text('name') }}
                        </div>
                    
                        <div class="mb-12">
                            <i
                                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" wire:click="$set('createModal', false)">{{ trans('Cancel') }}</i>
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">{{ trans('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="group-modal__overlay" wire:click="$set('createModal', false)"> </div>        
    @endif
    @if ($editModal)
        <div class="group-modal">
            <div class="text-right">
                <i class="fas fa-times fa-2x cursor-pointer" wire:click="$set('editModal', false)"></i>
            </div>
            <div>
                <h2> {{ trans('Group settings') }}</h2>
                <div class="group-modal__name">
                    <form wire:submit.prevent="saveGroup(Object.fromEntries(new FormData($event.target)))">
                        <input type="hidden" name="id" value="{{$selectedGroup->id}}">
                        {{ Form::label('Group Name', trans('Group Name')) }}
                        <div>
                            {{ Form::text('name', trans( $selectedGroup->name)) }}
                        </div>
                    
                        <div class="mb-12">
                            <i
                                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" wire:click="$set('editModal', false)">{{ trans('Cancel') }}</i>
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">{{ trans('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="group-modal__overlay" wire:click="$set('editModal', false)"> </div>        
    @endif
</div>
