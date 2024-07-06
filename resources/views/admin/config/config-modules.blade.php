<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.config', ['module' => 'general']) }}">{{ __('Configuration') }}</a></li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">

    <div class="card-header">

        <div class="row">

            <div class="col-12">
                @include('admin.config.includes.menu-config')
            </div>

        </div>

    </div>

    <div class="card-body">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                @if ($message == 'updated')
                    {{ __('Updated') }}
                @endif
            </div>
        @endif

        <form method="post">
            @csrf
            <div class="row">

                <div class="col-12">

                    <div class="fs-5 fw-bold mb-2 mt-2">{{ __('Enable / disable modules') }}:</div>

                    <div class="alert alert-light">
                        <b>{{ __('Active') }}</b>: {{ __('Module is enabled.') }}
                        <br>
                        <b>{{ __('Inactive') }}</b>: {{ __('Module is disabled.') }}                        
                        <br>
                        {{ __('Note: administrators and internal users (with module permission) have access to manage inactive modules, but the module is disabled on website.') }}  
                    </div>
                </div>


                {{--
                <div class="row mb-4">
                    <div class="col-md-6 col-lg-5 col-xl-4 col-xxl-3">
                        <div class="form-group mb-1">
                            <label>{{ __('Blog (articles, news, announcements, tutorials...)') }}</label>
                            <select name="module_posts" class="form-select @if (($config->module_posts ?? null) == 'active') is-valid @else is-invalid @endif">
                                <option @if (($config->module_posts ?? null) == 'active') selected @endif value="active">{{ __('Active') }}</option>
                                <option @if (($config->module_posts ?? null) == 'inactive') selected @endif value="inactive">{{ __('Inactive') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="text-muted small">
                            <i class="bi bi-info-circle"></i>
                            {{ __('Add articles (news, announcements, tutorials...) on website.') }}
                        </div>
                    </div>
                </div>
                --}}

                <div class="row mb-4">
                    <div class="col-md-6 col-lg-5 col-xl-4 col-xxl-3">
                        <div class="form-group mb-1">
                            <label>{{ __('Contact page') }}</label>
                            <select name="module_contact" class="form-select @if (($config->module_contact ?? null) == 'active') is-valid @else is-invalid @endif">
                                <option @if (($config->module_contact ?? null) == 'active') selected @endif value="active">{{ __('Active') }}</option>
                                <option @if (($config->module_contact ?? null) == 'inactive') selected @endif value="inactive">{{ __('Inactive') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="text-muted small">
                            <i class="bi bi-info-circle"></i>
                            {{ __('Add a contact page where visitors can send messages using a contact form. Messages are managed in backend area.') }}
                        </div>
                    </div>
                </div>
                            
                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </div>
            </div>
        </form>


    </div>
    <!-- end card-body -->

</div>
