<div>
    <button class="bg-blue-500 hover:bg-blue-700 mt-3 text-white font-bold py-2 px-4 rounded"  wire:click="$set('showModal', true)">{{ trans('Add user') }}</button>
    <div class="user-overview">
        <div class="user-overview__list">
            @foreach($users as $user)
            <div class="user-overview__list__item clearfix cursor-pointer" wire:click="editUserModal({{$user->id}})">
                <div class="user-overview__list__item__name">
                    {{ $user->fullName() }}
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
                <i class="fas fa-times fa-2x cursor-pointer" wire:click="closeModal"></i>
            </div>   
            @if ($selectedUser)
            <form wire:submit.prevent="editUser(Object.fromEntries(new FormData($event.target)))">
                <input name="id" type="hidden" value="{{$selectedUser->id}}">
                <input name="role_id" type="hidden" value="{{$selectedUser->role_id}}">
                <label for="first_name">Fornavn</label>
                <input name="first_name" type="text" value="{{$selectedUser->first_name}}">
                <label for="last_name">Efternavn</label>
                <input name="last_name" type="text" value="{{$selectedUser->last_name}}">
                <label for="email">Email</label>
                <input name="email" type="text" value="{{$selectedUser->email}}">
                <label for="locale">Sprog</label>
                <select name="locale">
                    <option value="null" @if ($selectedUser->locale == null)
                        selected='selected'
                    @endif>Vælg Sprog</option>
                    <option value="en" @if ($selectedUser->locale == "en")
                        selected='selected'
                    @endif>Engelsk</option>
                    <option value="da" @if ($selectedUser->locale == "da")
                        selected='selected'
                    @endif>Dansk</option>
                </select>
                <a href="#" class="block text-blue-500 hover:underline">Reset Password</a>
                <br>
                <div class="mt-3 inline block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded cursor-pointer" wire:click="deleteUser({{$selectedUser->id}})">Slet Bruger</div>
                <button class="mt-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Gem Bruger</button>
            </form>

            @else
                <form wire:submit.prevent="createUser(Object.fromEntries(new FormData($event.target)))">
                    <input name="role_id" type="hidden" value="2">
                    <label for="first_name">Fornavn</label>
                    <input name="first_name" type="text">
                    <label for="last_name">Efternavn</label>
                    <input name="last_name" type="text" >
                    <label for="email">Email</label>
                    <input name="email" type="text">
                    <label for="locale">Sprog</label>
                    <select name="locale">
                        <option value="null" selected='selected'>Vælg Sprog</option>
                        <option value="en">Engelsk</option>
                        <option value="da">Dansk</option>
                    </select>
                    <br>
                    <button class="mt-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Gem Bruger</button>
                    <div class="mt-3 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded cursor-pointer inline-block" wire:click="closeModal">Annuller</div>

                    </form>

            @endif
            
        </div>
    
        <div class="user-modal__overlay"  wire:click="closeModal"> </div>        
    @endif
</div>
