<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $site_text_dir }}">

<head>
    <title>{{ $tag->tag }}</title>

    <meta name="description" content="{{ $tag->tag }}">

    @include('web.global.head')
</head>

<body class="style_global">

    <!-- Start Main Content -->
    <div class="content">

        @include('web.global.navigation')

        @include('web.includes.posts-search')

        <div class="container-xxl mt-4 style_posts">

            @if (!($config->tpl_posts_categs_hide_breadcrumb ?? null))
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home', ['lang' => getRouteLang()]) }}">{{ __('Home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('posts', ['lang' => getRouteLang()]) }}">{{ $config_lang->posts_label ?? __('Posts') }}</a></li>
                                <li class="breadcrumb-item">{{ $tag->tag }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            @endif

            <div class="fs-4 mt-2 mb-3">
                {!! $tag->tag ?? null !!} ({{ $posts->total() }} {{ __('items') }})
            </div>

            @include('web.includes.posts-listing', ['listing_section' => 'tags'])            

            {{ $posts->links() }}
        </div>

    </div>
    <!-- End Main Content -->

    @include('web.global.footer')

</body>

</html>
