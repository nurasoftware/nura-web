<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="{{ $config->site_author ?? 'NuraWeb: Free and Open Source Website Builder - https://nuraweb.com' }}">

<!-- Favicon -->
@if ($config->favicon ?? null)
    <link rel="shortcut icon" href="{{ asset('uploads/' . $config->favicon) }}">
@else
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
@endif

<!-- Bootstrap CSS-->
@if (($langDir ?? null) == 'rtl')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-7mQhpDl5nRA5nY9lr8F1st2NbIly/8WqhjTp+0oFxEA/QUuvlbF6M1KXezGBh3Nb" crossorigin="anonymous">
@else
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
@endif

<!-- Bootstrap Fonts -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Fancybox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />

<!-- Main CSS Files -->
<link rel="stylesheet" href="{{ asset('assets/css/builder.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/blocks.css') }}" />

<!-- Custom CSS File -->
<link rel="stylesheet" href='{{ asset('assets/css/custom/custom.css') }}' />
<link rel="stylesheet" href='{{ asset('assets/css/custom/styles.css') }}' />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<!-- Fancybox Image gallery -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />

{!! $config->template_global_head_code ?? null !!}

@if (($config->google_analytics_id ?? null) && ($config->google_analytics_enabled ?? null))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $config->google_analytics_id ?? null }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{ $config->google_analytics_id ?? null }}');
    </script>
@endif
