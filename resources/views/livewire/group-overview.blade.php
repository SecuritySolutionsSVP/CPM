<div>
    <div class="group-overview">
        <div class="group-overview__list">
            @foreach ($groups as $group)
            <div class="group-overview__list__item clearfix">
                <div class="group-overview__list__item__name">
                    {{ $group->name }}
                </div>
                <div class="group-overview__list__item__created">
                    <a href="#">14:01 07/06/2021</a>
                </div>
                <div class="group-overview__list__item__icons">
                    <i class="fas fa-cogs group-overview__list__item__icons__open-settings" wire:click="editGroupModal({{$group->id}})"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @if ($showModal)
        <div class="group-modal">
            <div class="text-right">
                <i class="fas fa-times fa-2x cursor-pointer" wire:click="$set('showModal', false)"></i>
            </div>
            <div>
                {{ $selectedGroup->name }}
            </div>
        </div>
        <div class="group-modal__overlay" wire:click="$set('showModal', false)"> </div>        
    @endif
</div>
