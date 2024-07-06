<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.theme') }}">{{ __('Appearance') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Styles') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">

    <div class="card-header">

        <div class="row">

            <div class="col-12 mb-2">
                @include('admin.theme.includes.menu-theme')
            </div>

        </div>

    </div>


    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                @if ($message == 'created')
                    {{ __('Created') }}
                @endif
                @if ($message == 'updated')
                    {{ __('Updated') }}
                @endif
                @if ($message == 'deleted')
                    {{ __('Deleted') }}
                @endif
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger">
                @if ($message == 'duplicate')
                    {{ __('Error. This style exists') }}
                @endif
            </div>
        @endif


        <div class="card-title fs-5 fw-bold mb-1">{{ __('Global styles') }}</div>
        <div class="text-muted small mb-3">
            <i class="bi bi-info-circle"></i> {{ __('Define styes (fonts, colors, links, text sizes, backgrounds colors...) for global website (main style, menu navigation, footer)') }}
        </div>

        <div class="table-responsive-md">
            <table class="table table-bordered table-hover">
                <tbody>

                    <tr>
                        <td>
                            <div class="float-end ms-2">
                                <a class="btn btn-primary btn-sm mb-2" href="{{ route('admin.theme.styles.show', ['style' => 'global']) }}">{{ __('Update style') }}</a>
                            </div>

                            <div class="fs-6 fw-bold mb-1">
                                {{ __('Global Style') }}
                            </div>
                            <div class="text-muted small">{{ __('Global style is default style for entire website') }}</div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="float-end ms-2">
                                <a class="btn btn-primary btn-sm mb-2" href="{{ route('admin.theme.styles.show', ['style' => 'nav']) }}">{{ __('Update style') }}</a>
                            </div>

                            <div class="fs-6 fw-bold mb-1">
                                {{ __('Navigation Menu') }}
                            </div>
                            <div class="text-muted small">{{ __('Style for header navigation menu') }}</div>
                    </tr>

                    <tr>
                        <td>
                            <div class="float-end ms-2">
                                <a class="btn btn-primary btn-sm mb-2" href="{{ route('admin.theme.styles.show', ['style' => 'nav_dropdown']) }}">{{ __('Update style') }}</a>
                            </div>

                            <div class="fs-6 fw-bold mb-1">
                                {{ __('Navigation Dropdown') }}
                            </div>
                            <div class="text-muted small">{{ __('Style for dropdown menus (if available) from navigation menu') }}</div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="float-end ms-2">
                                <a class="btn btn-primary btn-sm mb-2" href="{{ route('admin.theme.styles.show', ['style' => 'footer']) }}">{{ __('Update style') }}</a>
                            </div>

                            <div class="fs-6 fw-bold mb-1">
                                {{ __('Footer') }}
                            </div>
                            <div class="text-muted small">{{ __('Style for primary footer') }}</div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="float-end ms-2">
                                <a class="btn btn-primary btn-sm mb-2" href="{{ route('admin.theme.styles.show', ['style' => 'footer2']) }}">{{ __('Update style') }}</a>
                            </div>

                            <div class="fs-6 fw-bold mb-1">
                                {{ __('Secondary Footer') }}
                            </div>
                            <div class="text-muted small">{{ __('Style for secondary footer (if enabled)') }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="clearfix mb-5"></div>

        <div class="float-end">
            <button class="btn btn-gear" data-bs-toggle="modal" data-bs-target="#create-style"><i class="bi bi-plus-circle"></i> {{ __('Create custom style') }}</button>
            @include('admin.theme.modals.create-style')
        </div>

        <div class="fs-5 fw-bold mb-1">{{ __('Custom styles') }}</div>

        <div class="text-muted small mb-3">
            <i class="bi bi-info-circle"></i> {{ __('Create custom styles for content blocks.') }}
        </div>

        <div class="table-responsive-md">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('Style') }}</th>
                        <th width="180">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($customStyles as $style)
                        <tr>
                            <td>
                                @if ($style->style == 'custom')
                                    <div class="float-end badge bg-light text-secondary">{{ __('Custom style') }}</div>
                                @endif

                                <div class="fs-6 fw-bold mb-2">
                                    @if ($style->is_default == 1)
                                        {{ __('Default style') }}
                                    @elseif($style->style == 'nav')
                                        {{ __('Navigation menu') }}
                                    @elseif($style->style == 'nav_dropdown')
                                        {{ __('Navigation dropdown') }}
                                    @elseif($style->style == 'footer')
                                        {{ __('Primary footer') }}
                                    @elseif($style->style == 'footer2')
                                        {{ __('Secondary footer') }}
                                    @else
                                        {{ $style->label }}
                                    @endif
                                </div>
                            </td>

                            <td>
                                <div class="d-grid gap-2">

                                    <a class="btn btn-primary btn-sm mb-2" href="{{ route('admin.theme.custom_styles.show', ['id' => $style->id]) }}">{{ __('Update style') }}</a>

                                    <a href="#" data-bs-toggle="modal" data-bs-target=".confirm-{{ $style->id }}" class="btn btn-danger btn-sm">{{ __('Delete style') }}</a>
                                    <div class="modal fade confirm-{{ $style->id }}" tabindex="-1" role="dialog" aria-labelledby="ConfirmDeleteLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ConfirmDeleteLabel">{{ __('Confirm delete') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('Are you sure you want to delete this style?') }}
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST" action="{{ route('admin.theme.custom_styles.show', ['id' => $style->id]) }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                        <button type="submit" class="btn btn-danger">{{ __('Yes. Delete') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{ $customStyles->links() }}


    </div>
    <!-- end card-body -->

</div>
