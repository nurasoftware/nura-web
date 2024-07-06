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
                @if ($message == 'updated')
                    {{ __('Updated') }}
                @endif
            </div>
        @endif

        <form method="post">
            @csrf

            <div class="fw-bold mb-2 mt-1">
                {{ __('Website status') }}:
                @if ($config->website_maintenance_enabled ?? null)
                    <span class="text-danger badge bg-warning text-uppercase">
                        {{ __('maintenance mode') }}
                    </span>
                @else
                    <span class="text-white badge bg-success text-uppercase">
                        {{ __('active') }}
                    </span>
                @endif
            </div>


            <div class="form-group mt-1 mb-0">
                <div class="form-check form-switch">
                    <input type="hidden" value="" name="website_maintenance_enabled">
                    <input class="form-check-input" type="checkbox" id="website_maintenance" name="website_maintenance_enabled" @if ($config->website_maintenance_enabled ?? null) checked @endif>
                    <label class="form-check-label" for="website_maintenance">{{ __('Enable maintenance mode') }}</label>
                </div>
            </div>

            <div class="text-muted mb-3">
                <i class="bi bi-info-circle"></i>
                {{ __('If enabled, public website can not be accessible by visitors and registered users can not use their accounts. Only administrators can use their accounts and see the website.') }}
            </div>

            <script>
                $('#website_maintenance').change(function() {
                    select = $(this).prop('checked');
                    if (select)
                        document.getElementById('hidden_div').style.display = 'block';
                    else
                        document.getElementById('hidden_div').style.display = 'none';
                })
            </script>

            <div id="hidden_div" @if ($config->website_maintenance_enabled ?? null) style="display: visible" @else style="display: none" @endif>
                <div class="form-group col-12">
                    <label>{{ __('Add a custom text for maintenance page') }} </label>
                    <textarea name="website_maintenance_text" class="form-control" rows="5">{!! $config->website_maintenance_text ?? null !!}</textarea>
                    <div class="text-muted small">{{ __('Tip: you can use HTML code.') }}</div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('Website author') }}</label>
                        <input type="text" class="form-control" name="site_author" value="{{ $config->site_author ?? null }}">
                        <small class="text-muted small">{{ __('Used in "meta author" tag') }}</small>
                    </div>
                </div>
            </div>

            @foreach ($languages as $lang)
                @php
                    $label_key = 'site_label_' . $lang->id;
                @endphp

                <div class="form-group">
                    <label>
                        @if (count($languages) > 1)
                            {!! flag($lang->code) !!}
                            @endif{{ __('Website label') }} @if (count($languages) > 1)
                                ({{ $lang->name }})
                            @endif
                    </label>
                    <input type="text" class="form-control" name="site_label_{{ $lang->id }}" value="{{ $site_labels[$lang->id]['site_label'] ?? null }}">
                    <div class="text-muted small">{{ __('A short website title (1-3 words)') }}</div>
                </div>


                @if (count($languages) > 1 && !$loop->last)
                    <hr>
                @endif
            @endforeach
            

            <div class="form-group mt-3">
                <input type="hidden" name="section" value="general">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </div>
        </form>

    </div>
    <!-- end card-body -->

</div>
