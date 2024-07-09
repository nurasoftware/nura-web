@if (!($config->tpl_post_hide_breadcrumb ?? null))
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb  @if ($config->tpl_post_head_align_center ?? null) justify-content-center @endif">
            <li class="breadcrumb-item"><a href="{{ route('home', ['lang' => getRouteLang()]) }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('posts', ['lang' => getRouteLang()]) }}">{{ $config_lang->posts_label ?? __('Posts') }}</a>
            </li>
            @foreach (breadcrumb($post->categ_id) as $bread_categ)
                <li class="breadcrumb-item"><a href="{{ $bread_categ->url }}">{{ $bread_categ->title }}</a></li>
            @endforeach
        </ol>
    </nav>
@endif

<div class="post">

    <div class="post_head @if ($config->tpl_post_head_align_center ?? null) text-center col-md-10 offset-md-1 @endif">

        <div class="title mb-3">{{ $post->title }}</div>

        @if ($post->summary)
            <div class="summary mb-3">
                {{ $post->summary }}
            </div>
        @endif

        <div class="meta mb-3">
            @if ($post->created_at)
                {{ date_locale($post->created_at) }}
            @endif

            @if ($post->hits)
                <i class="bi bi-eye ms-2"></i> {{ $post->hits }} {{ __('visits') }}
            @endif

            @if ($post->minutes_to_read > 0)
                <i class="bi bi-clock ms-2"></i> {{ $post->minutes_to_read }} {{ __('minutes read') }}
            @endif
        </div>

        @if ($post->image && !($config->tpl_post_hide_image ?? null))
            <div class="main-image mb-4 @if ($config->tpl_post_image_force_full_width ?? null) post-main-img-full-width @endif">
                <img class="img-fluid {{ $config->tpl_post_image_height_class ?? null }} @if ($config->tpl_post_image_rounded ?? null) rounded @endif @if ($config->tpl_post_image_shadow ?? null) shadow @endif"
                    src="{{ image($post->image) }}" alt="{{ $post->title }}" title="{{ $post->title }}">
            </div>
        @endif
    </div>

    <div class="addthis_inline_share_toolbox mb-2"></div>

    <div class="content">
        @foreach ($content_blocks as $block)
            @php
                $block_extra = unserialize($block['extra']);
            @endphp
            <div class="section @if ($block_extra['style_id'] ?? null) style_{{ $block_extra['style_id'] }} @endif" id="block-{{ $block['id'] }}">
                @include('web.includes.blocks-switch', ['is_post_content' => 1])
            </div>
        @endforeach
    </div>

    @if ($tags)
        <div class="tags mb-3">
            @foreach ($tags as $tag_item)
                <div class="me-3 mb-2 float-start"><a class="tag" href="{{ route('posts.tag', ['slug' => $tag_item->tag->slug, 'lang' => getRouteLang()]) }}">{{ $tag_item->tag->tag }}</a></div>
            @endforeach
        </div>
    @endif

</div>
