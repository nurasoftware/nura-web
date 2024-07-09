<nav class="nav nav-tabs" id="myTab" role="tablist">
    <a class="nav-item nav-link @if (($module ?? null) == 'global') active @endif" href="{{ route('admin.theme') }}">{{ __('Global') }}</a>
    <a class="nav-item nav-link @if (($module ?? null) == 'posts') active @endif" href="{{ route('admin.theme', ['module' => 'posts']) }}">{{ __('Posts') }}</a>
</nav>
