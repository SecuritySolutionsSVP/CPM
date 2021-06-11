<div>
    <div class="user-settings">  
        <form wire:submit.prevent="editUser(Object.fromEntries(new FormData($event.target)))">
            <label for="first_name">{{ trans('First name') }}</label>
            <input name="first_name" type="text" value="{{$user->first_name}}">
            <label for="last_name">{{ trans('Last name') }}</label>
            <input name="last_name" type="text" value="{{$user->last_name}}">
            <label for="email">{{ trans('Email') }}</label>
            <input name="email" type="text" value="{{$user->email}}">
            <label for="locale">{{ trans('Language') }}</label>
            <select name="locale">
                <option value="null" @if ($user->locale == null)
                    selected='selected'
                @endif>{{ trans('Choose Language') }}</option>
                <option value="en" @if ($user->locale == "en")
                    selected='selected'
                @endif>{{ trans('English') }}</option>
                <option value="da" @if ($user->locale == "da")
                    selected='selected'
                @endif>{{ trans('Danish') }}</option>
            </select>
            <label for="current_password">{{ trans('Current Password') }}</label>
            <input name="current_password" type="password" value="">
            <label for="password">{{ trans('Password') }}</label>
            <input name="password" type="password" value="">
            <label for="c_password">{{ trans('Verify Password') }}</label>
            <input name="c_password" type="password" value="">
            <a href="#" class="block text-blue-500 hover:underline">{{ trans('Reset Password') }}</a>
            <br>
            <div class="mt-3 inline block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded cursor-pointer" wire:click="deleteUser({{$user->id}})">{{ trans('Delete') }}</div>
            <button class="mt-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ trans('Save') }}</button>
        </form>
    </div>
</div>
