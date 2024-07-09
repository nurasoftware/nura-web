@if (($config->tpl_posts_style ?? null) == 'columns')
    @php
        if (($config->tpl_posts_columns ?? null) == 2) {
            $class = 'col-md-6 col-12';
        } elseif (($config->tpl_posts_columns ?? null) == 3) {
            $class = 'col-md-4 col-12';
        } elseif (($config->tpl_posts_columns ?? null) == 4) {
            $class = 'col-md-3 col-12';
        } else {
            $class = 'col-md-6 col-12';
        }
    @endphp

    <div class="row">
        @foreach ($posts as $post)
            @if (($listing_section ?? null) == 'tags')
                @php
                    $post = $post->post;
                @endphp
            @endif

            <div class="{{ $class }}">

                <div class="listing mb-5">
                    @if (!($config->tpl_posts_hide_image ?? null))
                        @if ($post->image)
                            <div class="mb-3 @if ($config->tpl_posts_image_zoom ?? null) img-zoom @endif">
                                <a title="{{ $post->title }}" href="{{ $post->url }}">
                                    <span class="listing-columns">
                                        <img src="{{ thumb($post->image) }}" class="img-fluid @if ($config->tpl_posts_image_shadow ?? null) shadow @endif @if ($config->tpl_posts_image_rounded ?? null) rounded @endif" alt="{{ $post->title }}">
                                    </span>
                                </a>
                            </div>
                        @endif
                    @endif

                    <div class="headings mb-3">
                        <a class="title" href="{{ $post->url }}">{{ $post->title }}</a>
                    </div>

                    @if (($config->tpl_posts_summary ?? null) && ($post->summary ?? null))
                        <div class="summary mb-3 {{ $config->tpl_posts_summary ?? null }}">
                            {{ $post->summary }}
                        </div>
                    @endif

                    <div class="meta">                       
                        @if (($config->tpl_posts_show_date ?? null) == 'date')
                            <span class="me-2"> {{ date_locale($post->created_at) }}</span>
                        @elseif (($config->tpl_posts_show_date ?? null) == 'datetime')
                            <span class="me-2"> {{ date_locale($post->created_at, 'datetime') }}</span>
                        @endif

                        @if ($config->tpl_posts_show_time_read ?? null)
                            <span class="me-2"><i class="bi bi-clock"></i> {{ $post->minutes_to_read }}
                                {{ __('min. read') }}</span>
                        @endif

                        @if ($config->tpl_posts_show_likes_count ?? null)
                            <span class="me-2"><i class="bi bi-hand-thumbs-up"></i>
                                {{ $post->likes }}</span>
                        @endif

                        @if ($config->tpl_posts_show_views_count ?? null)
                            <i class="bi bi-eye"></i> {{ $post->hits }}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    @foreach ($posts as $post)
        @if (($listing_section ?? null) == 'tags')
            @php
                $post = $post->post;
            @endphp
        @endif

        <div class="listing mb-5">
            <div class="row">

                @if (!($config->tpl_posts_hide_image ?? null))
                    <div class="col-xl-3 col-lg-5 col-md-5 col-12">
                        @if ($post->image)
                            <div class="mb-3 @if ($config->tpl_posts_image_zoom ?? null) img-zoom @endif">
                                <a title="{{ $post->title }}" href="{{ $post->url }}">
                                    <img src="{{ thumb($post->image) }}" class="img-fluid @if ($config->tpl_posts_image_shadow ?? null) shadow @endif @if ($config->tpl_posts_image_rounded ?? null) rounded @endif" alt="{{ $post->title }}">
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="@if (!($config->tpl_posts_hide_image ?? null)) col-xl-9 col-lg-7 col-md-7 @endif col-12">

                    <div class="headings mb-3">
                        <a class="title" href="{{ $post->url }}">{{ $post->title }}</a>
                    </div>

                    @if (($config->tpl_posts_summary ?? null) && ($post->summary ?? null))
                        <div class="summary mb-3 {{ $config->tpl_posts_summary ?? null }}">
                            {{ $post->summary }}
                        </div>
                    @endif

                    <div class="meta">                        
                        @if (($config->tpl_posts_show_date ?? null) == 'date')
                            <span class="me-2"> {{ date_locale($post->created_at) }}</span>
                        @elseif (($config->tpl_posts_show_date ?? null) == 'datetime')
                            <span class="me-2"> {{ date_locale($post->created_at, 'datetime') }}</span>
                        @endif

                        @if ($config->tpl_posts_show_time_read ?? null)
                            <span class="me-2"><i class="bi bi-clock"></i> {{ $post->minutes_to_read }}
                                {{ __('min. read') }}</span>
                        @endif

                        @if ($config->tpl_posts_show_likes_count ?? null)
                            <span class="me-2"><i class="bi bi-hand-thumbs-up"></i>
                                {{ $post->likes }}</span>
                        @endif

                        @if ($config->tpl_posts_show_views_count ?? null)
                            <i class="bi bi-eye"></i> {{ $post->hits }}
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endif
