<meta property="og:title" content="{{ $post->title }}" />
@if ($post->image)
    <meta property="og:image" content="{{ image($post->image) }}" />
@endif
<meta property="og:site_name" content="{{ $config->site_label ?? 'NuraPreess' }}" />
<meta property="og:description" content="{{ $post->meta_description ?? ($post->summary ?? strip_tags(substr($post->content, 0, 300))) }}" />
<meta property="fb:app_id" content="{{ $config->facebook_app_id ?? null }}" />
<meta property="og:type" content="article" />

@if ($config->posts_comments_fb_enabled ?? null)
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/{{ site()->locale ?? 'en_US' }}/sdk.js#xfbml=1&version=v15.0&appId={{ $config->facebook_app_id ?? null }}&autoLogAppEvents=1"
        nonce="Fr0Xvgjc"></script>
@endif
