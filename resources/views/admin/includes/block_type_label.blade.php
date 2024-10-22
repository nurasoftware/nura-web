@switch($type)
    @case('text')
        <i class="bi bi-file-text"></i> {{ __('Simple text') }}
    @break

    @case('editor')
        <i class="bi bi-textarea-t"></i> {{ __('Text Editor / HTML') }}
    @break

    @case('image')
        <i class="bi bi-image"></i> {{ __('Image / Banner') }}
    @break

    @case('gallery')
        <i class="bi bi-images"></i> {{ __('Images gallery') }}
    @break

    @case('card')
        <i class="bi bi-file-richtext"></i> {{ __('Cards') }}
    @break

    @case('hero')
        <i class="bi bi-card-heading"></i> {{ __('Hero') }}
    @break

    @case('links')
        <i class="bi bi-list-ul"></i> {{ __('Links') }}
    @break

    @case('video')
        <i class="bi bi-play-btn"></i> {{ __('Video') }}
    @break

    @case('slider')
        <i class="bi bi-collection"></i> {{ __('Slide') }}
    @break

    @case('custom')
        <i class="bi bi-code"></i> {{ __('Custom') }}
    @break

    @case('accordion')
        <i class="bi bi-menu-up"></i> {{ __('Accordion') }}
    @break

    @case('alert')
        <i class="bi bi-exclamation-square"></i> {{ __('Alert') }}
    @break

    @case('map')
        <i class="bi bi-geo-alt"></i> {{ __('Google Map') }}
    @break

    @case('blockquote')
        <i class="bi bi-chat-left-quote"></i> {{ __('Blockquote') }}
    @break
    
    @case('testimonial')
        <i class="bi bi-star-half"></i> {{ __('Testimonial') }}
    @break

    @default
        {{ $type }}
@endswitch
