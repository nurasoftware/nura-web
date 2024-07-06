@php
    $block_data = block($block['id']);    
@endphp

@if ($block_data->content ?? null)
    @php
        $block_item = unserialize($block_data->content);
    @endphp

    <div class="block">
        <div class="block-header mb-0">
            @if ($block_item['title'] ?? null)
                <div class="block-header-title">{!! $block_item['title'] !!}</div>
            @endif

            @if ($block_item['subtitle'] ?? null)
                <div class="block-header-subtitle mt-3">{!! $block_item['subtitle'] !!}</div>
            @endif

            @if ($block_item['content'] ?? null)
                <div class="block-text-content mt-3">{!! nl2br($block_item['content']) !!}</div>
            @endif
        </div>
    </div>
@endif
