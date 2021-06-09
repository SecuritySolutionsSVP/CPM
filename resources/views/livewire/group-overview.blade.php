<div>
    <div class="group-overview">
        <div class="group-overview__list">
            @for ($i = 0; $i < 10; $i++)
            <div class="group-overview__list__item clearfix" wire:click="$set('showModal', true)">
                <div class="group-overview__list__item__name">
                    Name of Group {{$i}}
                </div>
                <div class="group-overview__list__item__icons">
                    <i class="fas fa-cogs group-overview__list__item__icons__open-settings"></i>
                </div>
            </div>
            @endfor
        </div>
    </div>
    @if ($showModal)
        <div class="group-modal">
            <div class="text-right">
                <i class="fas fa-times fa-2x cursor-pointer" wire:click="$set('showModal', false)"></i>
            </div>   
        </div>
        <div class="group-modal__overlay" wire:click="$set('showModal', false)"> </div>        
    @endif
</div>
