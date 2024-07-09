<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $site_text_dir }}">

<head>
    <title>{{ __('Search') }} {{ $s }} - {{ $config_lang->site_label }}</title>
    
    <meta name="description" content="{{ __('Search') }} {{ $s }} - {{ $config_lang->site_label }}">
    
    @include('web.global.head')
</head>

<body class="style_global">

    <!-- Start Main Content -->
    <div class="content">

        @include('web.global.navigation')

        @include('web.includes.posts-search')

        <div class="container-xxl mt-5 style_posts">

            @include('web.includes.posts-listing')

            {{ $posts->links() }}
        </div>

    </div>

    @include('web.global.footer')

</body>

</html>
