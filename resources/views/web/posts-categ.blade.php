<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $site_text_dir }}">

<head>
    <title>{{ $categ->title }} | {{ $config_lang->site_label ?? null }}</title>

    <meta name="description" content="{{ $categ->description ?? $categ->title }}">

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
                                <li class="breadcrumb-item">{{ $categ->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            @endif

            @if (($config->posts_custom_content ?? null) && ($config->posts_custom_content_on_categs ?? null))
                <div class="custom_content">
                    @if ($config_lang->posts_custom_title ?? null)
                        <div class="mt-2 mb-3 title">
                            {!! $config_lang->posts_custom_title ?? null !!}
                        </div>
                    @endif

                    @if ($config_lang->posts_custom_text ?? null)
                        <div class="mt-2 mb-4 text">
                            {!! $config_lang->posts_custom_text ?? null !!}
                        </div>
                    @endif
                </div>
            @endif

            @if ($posts->total() == 0)
                {{ __('There are no items in this category') }}
            @endif

            @include('web.includes.posts-listing')

            {{ $posts->links() }}
            
        </div>
    </div>
    <!-- End Main Content -->

    @include('web.global.footer')

</body>

</html>
