<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">{{ __('Posts') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.posts.config') }}">{{ __('Settings') }}</a></li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">

    <div class="card-header">

        <div class="row">
            <div class="col-12 mb-3">
                @include('admin.posts.includes.menu')
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

            <div class="form-row">

                <div class="col-12">
                    <div class="fw-bold fs-5 mb-3">{{ __('Posts settings') }}</div>
                </div>


                <div class="form-group col-lg-2 col-md-3 col-12">
                    <label>{{ __('Posts per page') }}</label>
                    <input type="integer" name="posts_per_page" class="form-control" value="{{ $config->posts_per_page ?? 12 }}">
                </div>

                <div class="row">


                    <div class="col-12">
                        <div class="form-group mt-3 mb-0">
                            <div class="form-check form-switch">
                                <input type='hidden' value='' name='posts_addtoany_share_enabled'>
                                <input class="form-check-input" type="checkbox" id="posts_addtoany_share_enabled" name="posts_addtoany_share_enabled" @if ($config->posts_addtoany_share_enabled ?? null) checked @endif
                                    @if (!($config->addtoany_enabled ?? null)) disabled @endif>
                                <label class="form-check-label" for="posts_addtoany_share_enabled">{{ __('Enable AddToAny share buttons') }}</label>
                            </div>
                            @if (!($config->addtoany_enabled ?? null))
                                <div class="form-text text-danger">{{ __('AddToAny disabled') }}. <a href="{{ route('admin.config', ['module' => 'integration']) }}">{{ __('Change') }}</a></div>
                            @endif
                            <div class="form-text">{{ __('You can use AddToAny to add social share buttons in your posts.') }}</div>
                        </div>
                    </div>                   
                </div>

            </div>


            <hr>
            <div class="fw-bold fs-5 mb-3">{{ __('SEO settings') }}</div>

            @foreach ($seo_configs as $config)
                @if (count($languages) > 1)
                    <h5 class="mb-2">{!! flag($config['lang']->code) !!} {{ $config['lang']->name }} @if ($config['lang']->is_default)
                            ({{ __('default language') }})
                        @endif
                    </h5>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>{{ __('Label') }}</label>
                            <input name="label_{{ $config['lang']->id }}" class="form-control" value="{{ $config['label'] ?? null }}">
                            <div class="form-text text-muted small">{{ __('Label is used in breadcrumb navigation') }}</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>{{ __('Meta title') }}</label>
                            <input name="meta_title_{{ $config['lang']->id }}" class="form-control" value="{{ $config['meta_title'] ?? null }}">
                            <div class="form-text text-muted small">{{ __('Meta title for Posts main page') }}</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>{{ __('Meta description') }}</label>
                            <textarea rows="2" name="meta_description_{{ $config['lang']->id }}" class="form-control">{{ $config['meta_description'] ?? null }}</textarea>
                            <div class="form-text text-muted small">{{ __('Meta description for Posts main page') }}</div>
                        </div>
                    </div>
                </div>

                @if (count($languages) > 1 && !$loop->last)
                    <hr>
                @endif
            @endforeach

            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                </div>
            </div>

        </form>

    </div>
    <!-- end card-body -->

</div>
