<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Languages') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>



<div class="card">

    <div class="card-header">

        <div class="row">

            <div class="col-12 mb-2">
                @include('admin.config.includes.menu-config')
            </div>

            <div class="col-12 col-sm-5 col-md-6 order-md-1 order-first">
                <h4 class="card-title">{{ __('Languages') }}</h4>
            </div>

            <div class="col-12 col-sm-7 col-md-6 order-md-2 order-last">
                <div class="float-end">
                    <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#create-lang"><i class="bi bi-plus-circle"></i> {{ __('Add language') }}</a>
                    @include('admin.config.modals.create-lang')

                    <span class="float-end ms-2"><a class="btn btn-secondary" href="{{ route('admin.translates') }}"><i class="bi bi-flag"></i> {{ __('Manage translates') }}</a></span>

                </div>
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
                    <h5 class="alert-heading">{{ __('Created') }}</h5>
                    <i class="bi bi-exclamation-circle"></i>
                    {{ __('Important: You MUST create menu links for new created languages.') }} <a href="{{ route('admin.theme.menu') }}">{{ __('Menu links') }}</a>
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
                    {{ __('Error. This language exist') }}
                @endif
                @if ($message == 'exists_content')
                    {{ __('Error. This language can not be deleted because there is content in this language. You can make this language inactive') }}
                @endif
                @if ($message == 'default')
                    {{ __('Error. Default language can not be deleted') }}
                @endif
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>{{ __('Details') }}</th>
                        <th width="80">{{ __('Code') }}</th>
                        <th width="300">{{ __('Locale') }}</th>
                        <th width="130">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($langs as $lang)
                        @php
                            $permalinks = unserialize($lang->permalinks);
                        @endphp

                        <tr @if ($lang->status != 'active') class="table-light" @endif>
                            <td>
                                @if ($lang->status == 'active')
                                    <span class="float-end ms-2 badge bg-success">{{ __('Active') }}</span>
                                @endif
                                @if ($lang->status == 'inactive')
                                    <span class="float-end ms-2 badge bg-warning">{{ __('Inactive') }}</span>
                                @endif
                                @if ($lang->status == 'disabled')
                                    <span class="float-end ms-2 badge bg-danger">{{ __('Disabled') }}</span>
                                @endif


                                @if ($lang->is_default == 1)
                                    <span class="float-end ms-2 badge bg-primary">{{ __('Default') }}</span>
                                @endif
                                <div class="fw-bold fs-5">{!! flag($lang->code) !!} {{ $lang->name }}</div>

                                <a target="_blank" href="{{ route('home') }}@if ($lang->is_default == 0)/{{ $lang->code }} @endif">
                                    {{ route('home') }}@if ($lang->is_default == 0)/{{ $lang->code }}@endif
                                </a>

                                <div class="small text-muted mt-1">
                                    <b>{{ __('Site label') }}</b>: 
                                    @if( $lang->site_label) {{ $lang->site_label }}
                                    @else 
                                        <span class="fw-bold text-danger">{{ __('not set') }}</span>
                                    @endif
                                    @if ($lang->dir == 'rtl')
                                        <br>{{ __('Text direction: RTL') }}
                                    @endif
                                </div>
                            </td>

                            <td>
                                <h5>{{ $lang->code }}</h5>
                            </td>


                            <td>
                                <div class="small texx-muted">
                                    <b>{{ __('Locale') }}: {{ $lang->locale }}</b>
                                    <div class="mb-2"></div>
                                    {{ __('Date format') }}:
                                    @php
                                        setlocale(LC_ALL, $lang->locale);
                                    @endphp
                                    {{ strftime('%A %e %B %Y', mktime(0, 0, 0, 12, 22, 1978)) }}

                                    <div class="mb-2"></div>
                                    {{ __('Timezone') }}: {{ $lang->timezone ?? 'Europe/London' }}
                                    <div class="mb-2"></div>
                                </div>
                            </td>

                            <td>
                                <div class="d-grid gap-2">
                                    <button data-bs-toggle="modal" data-bs-target="#update-lang-{{ $lang->id }}" class="btn btn-primary btn-sm">{{ __('Settings') }}</button>
                                    @include('admin.config.modals.update-lang')

                                    <a class="btn btn-secondary btn-sm mt-2" href="{{ route('admin.translate_lang', ['id' => $lang->id]) }}">{{ __('Translates') }}</a>

                                    @if ($lang->is_default != 1)
                                        <a href="#" data-bs-toggle="modal" data-bs-target=".confirm-{{ $lang->id }}" class="btn btn-danger btn-sm mt-2">{{ __('Delete') }}</a>
                                        <div class="modal fade confirm-{{ $lang->id }}" tabindex="-1" role="dialog" aria-labelledby="ConfirmDeleteLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ConfirmDeleteLabel">{{ __('Confirm delete') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ __('Are you sure you want to delete this language?') }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="POST" action="{{ route('admin.languages.show', ['id' => $lang->id]) }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                            <button type="submit" class="btn btn-danger">{{ __('Yes. Delete') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>
    <!-- end card-body -->

</div>
