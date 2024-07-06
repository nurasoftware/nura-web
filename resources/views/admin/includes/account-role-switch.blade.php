@switch($role)
    @case('admin')
        {{ __('Administrator') }}
    @break

    @case('internal')
        {{ __('Internal') }}
    @break

    @case('user')
        {{ __('Registered user') }}
    @break

    @default
        {{ $role }}
@endswitch
