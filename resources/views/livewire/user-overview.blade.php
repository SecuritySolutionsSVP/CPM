<div>
    <div class="user-overview">
        <div class="user-overview__list">
            @foreach($users as $user)
            <div class="user-overview__list__item clearfix" wire:click="$set('showModal', true)">
                <div class="user-overview__list__item__name">
                    {{ $user->fullName() }}
                </div>
                <div class="user-overview__list__item__created">
                    <a href="#">{{ $user->created_at->diffForHumans() }}</a>
                </div>
                <div class="user-overview__list__item__icons">
                    <i class="fas fa-cogs user-overview__list__item__icons__open-settings"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @if ($showModal)
        <div class="user-modal">
            <div class="text-right">
                <i class="fas fa-times fa-2x cursor-pointer" wire:click="$set('showModal', false)"></i>
            </div>   
            {{ $selectedUser->}}
        </div>
        <div class="user-modal__overlay" wire:click="$set('showModal', false)"> </div>        
    @endif
</div>
