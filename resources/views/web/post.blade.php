<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $site_text_dir }}">

<head>
    <title>{{ $post->meta_title ?? $post->title }}</title>
    <meta name="description" content="{{ $post->meta_description ?? ($post->summary ?? strip_tags(substr($post->content, 0, 300))) }}">

    @include('web.global.head')

    <!-- BEGIN CSS for this page -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css" />
    <!-- END CSS for this page -->
</head>

<body class="style_global">

    <!-- Start Main Content -->
    <div class="content">

        @include('web.global.navigation')

        @include('web.includes.posts-search')

        <div class="container-xxl mt-4 style_posts">
            @include('web.includes.post-item')
        </div>

    </div>
    <!-- End Main Content -->

    @include('web.global.footer')

</body>

</html>
