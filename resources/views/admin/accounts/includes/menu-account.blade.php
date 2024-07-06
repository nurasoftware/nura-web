<nav class="nav nav-tabs" id="myTab" role="tablist">
    <a class="nav-item nav-link @if ($menu_section == 'details') active @endif" href="{{ route('admin.accounts.show', ['id' => $account->id]) }}"><i class="bi bi-person" aria-hidden="true"></i> {{ __('Details') }}</a>    

    {{--
    @if ($account->role == 'internal' && Auth::user()->role == 'admin') 
        <a target="_blank" class="nav-item nav-link" href="{{ route('admin.accounts.permissions', ['search_user_id' => $account->id]) }}"><i class="bi bi-person-lock"></i> {{ __('Permissions') }}</a>
    @endif
    --}}
</nav>
