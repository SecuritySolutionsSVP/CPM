<div>
    <div class="user-overview">
        <div class="user-overview__list">
            @for ($i = 0; $i < 10; $i++)
            <div class="user-overview__list__item clearfix" wire:click="$set('showModal', true)">
                <div class="user-overview__list__item__name">
                    Name of user {{$i}}
                </div>
                <div class="user-overview__list__item__created">
                    <a href="#">14:01 07/06/2021</a>
                </div>
                <div class="user-overview__list__item__icons">
                    <i class="fas fa-cogs user-overview__list__item__icons__open-settings"></i>
                </div>
            </div>
            @endfor
        </div>
    </div>
    @if ($showModal)
        <div class="user-modal">
            <div class="text-right">
                <i class="fas fa-times fa-2x cursor-pointer" wire:click="$set('showModal', false)"></i>
            </div>   
        </div>
        <div class="user-modal__overlay" wire:click="$set('showModal', false)"> </div>        
    @endif
</div>
