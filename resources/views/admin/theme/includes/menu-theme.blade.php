<nav class="nav nav-tabs" id="myTab" role="tablist">
    <a class="nav-item nav-link @if ($menu_section == 'theme') active @endif" href="{{ route('admin.theme') }}"><i class="bi bi-laptop"></i> {{ __('Theme') }}</a>
    <a class="nav-item nav-link @if ($menu_section == 'menu') active @endif" href="{{ route('admin.theme.menu') }}"><i class="bi bi-menu-down"></i> {{ __('Menu links') }}</a>
    <a class="nav-item nav-link @if ($menu_section == 'footer') active @endif" href="{{ route('admin.theme.footer') }}"><i class="bi bi-menu-up"></i> {{ __('Footer') }}</a>
    <a class="nav-item nav-link @if ($menu_section=='buttons') active @endif" href="{{ route('admin.theme.buttons.index') }}"><i class="bi bi-check2-square"></i> {{ __('Buttons') }}</a>
    <a class="nav-item nav-link @if ($menu_section=='styles') active @endif" href="{{ route('admin.theme.styles.index') }}"><i class="bi bi-palette"></i> {{ __('Styles') }}</a>
    <a class="nav-item nav-link @if ($menu_section == 'logo') active @endif" href="{{ route('admin.theme.logo') }}"><i class="bi bi-image"></i> {{ __('Logo & icons') }}</a>
    <a class="nav-item nav-link @if ($menu_section == 'custom_code') active @endif" href="{{ route('admin.theme.custom_code') }}"><i class="bi bi-code-square"></i> {{ __('Custom code') }}</a>
</nav>
