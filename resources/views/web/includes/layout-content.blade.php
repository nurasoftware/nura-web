@foreach (content_blocks($module, $content_id) as $block)
    @php
        $block_extra = unserialize($block['extra']);
    @endphp

    <div class="section @if ($block_extra['style_id'] ?? null) style_{{ $block_extra['style_id'] }} @endif" id="block-{{ $block['id'] }}">
        @include('web.includes.blocks-switch')
    </div>
@endforeach
