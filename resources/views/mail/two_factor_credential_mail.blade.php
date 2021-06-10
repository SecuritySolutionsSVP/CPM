<div>
    <p>{{ trans('You have requested access to asset') }}: {{ $credential->credentialGroup->name }}</p>
    <p>{{ trans('For username') }}: {{ $credential->username }}</p>

    <p>{{ trans('Please enter the following token into your browser') }}:</p>
    <p>{{ $token }}</p>

    <p>{{ trans('Expires in 10 minutes') }}</p>
</div>