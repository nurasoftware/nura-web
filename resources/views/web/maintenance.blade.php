<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $site_text_dir }}">

<head>

    <title>{{ __('Maintenance mode') }}</title>

    @include('web.global.head')

</head>

<body class="style_global">

    <!-- Start Main Content -->
    <div class="content">

        <div class="container">
            <div class="mt-5">
                {!! $config->website_maintenance_text ?? __('Maintenance mode') !!}
            </div>

            @if (Auth::user() ?? null)
                <hr>
                <i class="bi bi-info-circle"></i> {{ __('You are logged as') }} <b>{{ Auth::user()->name }}</b>.

                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'internal')
                    <div class="mt-3">
                        <a class="fw-bold" href="{{ route('admin') }}">{{ __('Go to my account') }}</a>

                        @if (Auth::user()->role == 'admin')
                            <span class="ms-3">
                                <a class="fw-bold" href="{{ route('home') }}">{{ __('Preview website') }}</a>
                            </span>
                        @endif
                    </div>
                @else
                    <a class="fw-bold" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none;">
                        @csrf
                    </form>
                @endif
            @endif
        </div>
    </div>
    <!-- End Main Content -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    {!! $config->template_global_footer_code ?? null !!}

</body>

</html>
