<nav class="nav nav-tabs mb-2" id="myTab" role="tablist">
    <a class="nav-item nav-link @if ($active_tab == 'general') active @endif" href="{{ route('admin.config', ['module' => 'general']) }}"><i class="bi bi-gear"></i> {{ __('Website') }}</a>
    <a class="nav-item nav-link @if ($active_tab == 'modules') active @endif" href="{{ route('admin.config', ['module' => 'modules']) }}"><i class="bi bi-check-square"></i> {{ __('Modules') }}</a>
    <a class="nav-item nav-link @if ($active_tab == 'contact') active @endif" href="{{ route('admin.config', ['module' => 'contact']) }}"><i class="bi bi-envelope"></i> {{ __('Contact page') }}</a>
    <a class="nav-item nav-link @if ($active_tab == 'integration') active @endif" href="{{ route('admin.config', ['module' => 'integration']) }}"><i class="bi bi-arrow-right-square"></i> {{ __('Integration') }}</a>
    <a class="nav-item nav-link @if ($active_tab == 'icons') active @endif" href="{{ route('admin.config', ['module' => 'icons']) }}"><i class="bi bi-star"></i> {{ __('Icons') }}</a>
    <a class="nav-item nav-link @if ($active_tab == 'languages') active @endif" href="{{ route('admin.languages.index') }}"><i class="bi bi-translate"></i> {{ __('Languages') }}</a>
</nav>
