<div>
    <p>{{ trans('You have requested access to asset') }}: {{ $credential->credentialGroup->name }}</p>
    <p>{{ trans('For user') }}: {{ $credential->username }}</p>

    <p>{{ trans('Please enter the following token into your browser') }}:</p>
    <p>{{ $token }}</p>
</div>