<div>
    <button class="bg-green-500 hover:bg-green-700 mt-3 text-white font-bold py-2 px-4 rounded"  wire:click="$set('showModal', true)">Opret Bruger</button>
    <div class="user-overview">
        <div class="user-overview__list">
            @foreach($users as $user)
            <div class="user-overview__list__item clearfix" wire:click="editUserModal({{$user->id}})">
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
            <form>
                <label for="first_name">Fornavn</label>
                <input name="first_name" type="text" value="{{$selectedUser->first_name}}">
                <label for="last_name">Efternavn</label>
                <input name="last_name" type="text" value="{{$selectedUser->last_name}}">
                <label for="email">Email</label>
                <input name="email" type="text" value="{{$selectedUser->email}}">
                <label for="localization">Sprog</label>
                <select name="localization">
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
            </form>
            <div class="pt-3">
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" wire:click="deleteUser({{$selectedUser->id}})">Slet Bruger</button>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Gem Bruger</button>
            </div>
            @else
                <form>
                    <label for="first_name">Fornavn</label>
                    <input name="first_name" type="text">
                    <label for="last_name">Efternavn</label>
                    <input name="last_name" type="text" >
                    <label for="email">Email</label>
                    <input name="email" type="text">
                    <label for="localization">Sprog</label>
                    <select name="localization">
                        <option value="null" selected='selected'>Vælg Sprog</option>
                        <option value="en">Engelsk</option>
                        <option value="da">Dansk</option>
                    </select>
                </form>
                <div class="pt-3">
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" wire:click="closeModal">Annuller</button>
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Gem Bruger</button>
                </div>

            @endif
            
        </div>
    
        <div class="user-modal__overlay"  wire:click="closeModal"> </div>        
    @endif
</div>
