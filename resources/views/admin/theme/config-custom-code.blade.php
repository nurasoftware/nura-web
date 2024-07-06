<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.theme') }}">{{ __('Appearance') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Custom code') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>



<div class="card">

    <div class="card-header">

        @include('admin.theme.includes.menu-theme')

    </div>


    <div class="card-body">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                @if ($message == 'updated')
                    {{ __('Updated') }}
                @endif
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger">
                @if ($message == 'invalid_file')
                    {{ __('Invalid file., Only css and javascript files are allowed') }}
                @endif
            </div>
        @endif

        <div class="mb-2">
            <i class="bi bi-info-circle"></i> {!! __('<b>This codes will be added in all themes.</b> If you need to insert code for a theme, you can edit theme and add custom code for a specific theme.') !!}
        </div>

        <div class="mb-3">
            {{ __('Head code is inserted inside <head>...</head> section in your template code.') }}.<br>
            {{ __('Footer code is inserted at the end section in your template code.') }}.<br>
            {{ __('You can add global css / javascript code or link to external css / js files.') }}.
        </div>

        <form method="post">
            @csrf

            <div class="form-row">

                <div class="form-group col-12">
                    <label>{{ __('Code added in theme head') }}</label>
                    <textarea class="form-control" name="themes_global_head_code" rows="10">{{ $config->themes_global_head_code ?? null }}</textarea>
                </div>

                <div class="form-group col-12">
                    <label>{{ __('Code added in theme footer') }}</label>
                    <textarea class="form-control" name="themes_global_footer_code" rows="10">{{ $config->themes_global_footer_code ?? null }}</textarea>
                </div>

            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </div>
        </form>

    </div>
    <!-- end card-body -->

</div>
