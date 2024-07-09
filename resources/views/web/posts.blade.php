<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $site_text_dir }}">

<head>
    <title>{{ $config_lang->posts_meta_title ?? __('Blog') }}</title>
    <meta name="description" content="{{ $config_lang->posts_meta_description ?? __('Blog') }}">

    @include('web.global.head')
</head>

<body class="style_global">

    <!-- Main Content -->
    <div class="content">

        @include('web.global.navigation')

        @include('web.includes.posts-search')


        <div class="container-xxl mt-4 style_posts">
            @if ($config->posts_custom_content ?? null)
                <div class="custom_content">
                    @if ($config_lang->posts_custom_title ?? null)
                        <div class="mt-4 mb-3 title">
                            {!! $config_lang->posts_custom_title ?? null !!}
                        </div>
                    @endif

                    @if ($config_lang->posts_custom_text ?? null)
                        <div class="mt-3 mb-4 text">
                            {!! $config_lang->posts_custom_text ?? null !!}
                        </div>
                    @endif
                </div>
            @endif

            @if (!($config->tpl_posts_hide_categs_list ?? null))
                @if (count($categories) > 0)
                    <div class="mb-1 fw-bold">
                        {{ __('Categories') }}:
                    </div>

                    <div class="mb-5 mt-4 categ-list d-block clearfix">
                        @foreach ($categories as $categ)
                            @if (($config->tpl_posts_categs_list_hide_if_empty ?? null) && $categ->posts_count == 0)
                                @php continue @endphp
                            @endif

                            @php
                                if ($categ->lang_id == $default_language->id) {
                                    $categ_url = route('posts.categ', ['categ_slug' => $categ->slug]);
                                } else {
                                    $categ_url = route('posts.categ.'.get_language_code_from_id($categ->lang_id), ['categ_slug' => $categ->slug]);
                                }
                            @endphp

                            <div class="float-start d-block me-4">
                                <a class="@if (($config->tpl_posts_categs_list_layout ?? null) == 'boxes') posts-categ-item-box @else posts-categ-item-link @endif" href="{{ $categ_url }}">{{ $categ->title }} @if ($config->tpl_posts_categs_list_show_counter ?? null)
                                        ({{ $categ->posts_count }})
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif


            @include('web.includes.posts-listing')
            {{ $posts->links() }}

        </div>


    </div>
    <!-- End Main Content -->

    @include('web.global.footer')

</body>

</html>
