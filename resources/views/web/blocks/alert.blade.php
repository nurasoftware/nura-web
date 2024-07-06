@php
    $block_data = block($block['id']);
@endphp

@if ($block_data->content ?? null)
    @php
        $block_items = unserialize($block_data->content);
    @endphp

    @if ($block_items['title'] || $block_items['content'])
        <div class="block">
            <div class="alert alert-{{ $block_extra['type'] ?? 'info' }} block-alert-item" role="alert">
                @if ($block_items['title'] ?? null)
                    <div class="block-alert-title">{{ $block_items['title'] }}</div>
                @endif
                @if ($block_items['content'] ?? null)
                    <div class="block-alert-content">{!! nl2br($block_items['content']) !!}</div>
                @endif
            </div>
        </div>
    @endif

@endif
