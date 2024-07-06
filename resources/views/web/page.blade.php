<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $site_text_dir }}">

<head>

    <title>{{ $meta_title }}</title>
    <meta name="description" content="{{ $meta_description }}">

    @include('web.global.head')

</head>

<body class="style_global">

    <!-- Start Main Content -->
    <div class="content">
        @include('web.global.navigation')

        @include('web.includes.layout-content')
    </div>
    <!-- End Main Content -->

    @include('web.global.footer')

    {{ dd($locale) }}
    
</body>

</html>
