<!-- Left Sidebar -->
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo mt-1">
                    <a href="{{ route('admin') }}"><img src="{{ asset('assets/img/logo-backend.png') }}" class="img-fluid" alt="{{ config('app.name') }}"></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-item @if (($active_menu ?? null) == 'dashboard') active @endif">
                    <a href="{{ route('admin') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>

                <li class="sidebar-item @if (($active_menu ?? null) == 'accounts') active @endif">
                    <a href="{{ route('admin.accounts.index') }}" class='sidebar-link'>
                        <i class="bi bi-people"></i>
                        <span>{{ __('Accounts') }}</span>
                    </a>
                </li>

                <li class="sidebar-item @if (($active_menu ?? null) == 'pages') active @endif">
                    <a href="{{ route('admin.pages.index') }}" class='sidebar-link'>
                        <i class="bi bi-files"></i>
                        <span>{{ __('Pages') }}</span>
                    </a>
                </li>

                <li class="sidebar-item @if (($active_menu ?? null) == 'posts') active @endif">
                    <a href="{{ route('admin.posts.index') }}" class='sidebar-link'>
                        <i class="bi bi-file-text"></i>
                        <span>{{ __('Blog / Articles') }}</span>
                    </a>
                </li>
                
                <li class="sidebar-item @if (($active_menu ?? null) == 'contact') active @endif">
                    <a href="{{ route('admin.contact') }}" class='sidebar-link'>
                        <i class="bi bi-envelope"></i>
                        <span>{{ __('Contact messages') }}</span>
                        @if ($count_unread_contact_messages ?? null > 0)
                            <span class="badge bg-danger">{{ $count_unread_contact_messages }}</span>
                        @endif
                    </a>
                </li>

                <li class="sidebar-item @if (($active_menu ?? null) == 'theme') active @endif">
                    <a href="{{ route('admin.theme') }}" class='sidebar-link'>
                        <i class="bi bi-laptop"></i>
                        <span>{{ __('Appearance') }}</span>
                    </a>
                </li>

                <li class="sidebar-item @if (($active_menu ?? null) == 'config') active @endif">
                    <a href="{{ route('admin.config', ['module' => 'general']) }}" class='sidebar-link'>
                        <i class="bi bi-gear-fill"></i>
                        <span>{{ __('Configuration') }}</span>
                    </a>
                </li>

                <li class="sidebar-item @if (($active_menu ?? null) == 'recycle_bin') active @endif">
                    <a href="{{ route('admin.recycle_bin') }}" class='sidebar-link'>
                        <i class="bi bi-trash"></i>
                        <span>{{ __('Recycle Bin') }}</span>
                    </a>
                </li>

                @foreach (config('custom-nura.sidebar_admin_items') as $custom_item => $custom_value)
                    @if ($custom_value['items'] ?? null)
                        <li class="sidebar-item has-sub @if (($active_menu ?? null) == $custom_item) active @endif">
                            <a href="#" class='sidebar-link'>
                                {!! $custom_value['icon'] !!} <span>{{ $custom_value['label'] }}</span>
                            </a>
                            <ul class="submenu @if (($active_menu ?? null) == $custom_item) active @endif">
                                @foreach ($custom_value['items'] as $dropdown_custom_item => $dropdown_custom_value)
                                    <li class="submenu-item @if (($active_submenu ?? null) == $dropdown_custom_item) active @endif">
                                        <a href="{{ route($dropdown_custom_value['route']) }}">{{ $dropdown_custom_value['label'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="sidebar-item @if (($active_menu ?? null) == $custom_item) active @endif">
                            <a href="{{ route($custom_value['route']) }}" class='sidebar-link'>
                                {!! $custom_value['icon'] !!} <span>{{ $custom_value['label'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
<!-- End Sidebar -->
