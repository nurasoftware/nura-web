<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.themes.index') }}">{{ __('Appearance') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ __('Themes') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">

    <div class="card-header">

        @include('admin.theme.includes.menu-themes')

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
                    {{ __('Error. This button exists') }}
                @endif
            </div>
        @endif

        <div class="fw-bold fs-5 mb-3">{{ __('Active template') }}</div>

        <div class="card card-template bg-light">
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-md-4 col-12">
                    @if ($active_theme['screenshot'])
                        <img src="{{ asset($active_theme['screenshot']) }}" class="card-img-top" alt="{{ $active_theme['name'] }}">
                    @else
                        <img src="{{ asset('assets/img/no-image.png') }}" class="card-img-top" alt="No image">
                    @endif
                </div>

                <div class="col-xl-10 col-lg-9 col-md-8 col-12">

                    <div class="card-body">
                        <h4 class="card-title">{{ $active_theme['name'] }}</h4>
                        <p class="card-text">{{ $active_theme['description'] }}</p>

                        <a href="{{ route('admin.themes.show', ['slug' => basename($active_theme['path'])]) }}" class="btn btn-gear btn-lg"><i class="bi bi-pencil-square"></i>
                            {{ __('Edit template') }}</a>

                        <a class="btn btn-secondary btn-lg ms-3" target="_blank" href="{{ route('home', ['preview_template' => basename($active_theme['path'])]) }}"><i class="bi bi-box-arrow-up-right"></i>
                            {{ __('Preview') }}</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="fw-bold fs-5 mb-3 mt-4">{{ __('All templates') }}</div>

        <div class="row row-cols-1 row-cols-md-3 row-cols-xl-4 g-4">
            @foreach ($themes as $theme)
                <div class="col">
                    <div class="card card-template h-100">
                        @if ($theme['screenshot'])
                            <img src="{{ asset($theme['screenshot']) }}" class="card-img-top" alt="{{ $active_theme['name'] }}">
                        @else
                            <img src="{{ asset('assets/img/no-image.png') }}" class="card-img-top" alt="No image">
                        @endif

                        <div class="card-body bg-light">
                            @if ($config->active_theme != basename($theme['path']))
                                <a href="{{ route('admin.themes.set_default', ['slug' => basename($theme['path'])]) }}" class="btn btn-danger me-2"><i class="bi bi-check-square"></i>
                                    {{ __('Set default') }}</a>
                            @endif

                            <a href="{{ route('admin.themes.show', ['slug' => basename($theme['path'])]) }}" class="btn btn-success me-2"><i class="bi bi-pencil-square"></i>
                                {{ __('Edit template') }}</a>

                            <a class="btn btn-secondary me-2" target="_blank" href="{{ route('home', ['preview_theme' => basename($theme['path'])]) }}"><i class="bi bi-box-arrow-up-right"></i>
                                {{ __('Preview') }}</a>

                            <hr>

                            @if ($config->active_theme == basename($theme['path']))
                                <span class="float-end ms-2 badge bg-info">{{ __('Active') }}</span>
                            @endif
                            <h4 class="card-title">{{ $theme['name'] }}</h4>
                            <p class="card-text">{{ $theme['description'] }}</p>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <!-- end card-body -->

</div>
