@foreach (footer_blocks($footer, 1) as $block)
    @php
        $block_extra = unserialize($block->extra);
    @endphp

    <div class="section" id="footer-block-{{ $block->id }}">
        @include('web.includes.footer-blocks-switch')
    </div>
@endforeach
