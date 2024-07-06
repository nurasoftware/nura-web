@php
    $block_data = block($block['id']);
@endphp

@if ($block_data->content ?? null)
    @php
        $block_item = unserialize($block_data->content);
        $block_header = unserialize($block_data->header ?? null);
    @endphp

    <div class="block text-center">

        @if ($block_header['add_header'] ?? null)
            <div class="block-header">
                @if ($block_header['title'] ?? null)
                    <div class="block-header-title title">
                        {{ $block_header['title'] ?? null }}
                    </div>
                @endif

                @if ($block_header['content'] ?? null)
                    <div class="block-header-content mt-4">
                        {!! $block_header['content'] ?? null !!}
                    </div>
                @endif
            </div>
        @endif

        @if ($block_item['embed'] ?? null)
            <div @if ($block_extra['full_width_responsive'] ?? null) class="ratio ratio-16x9" @endif>
                {!! $block_item['embed'] !!}
            </div>
            @if ($block_item['caption'] ?? null)
                <div class="caption">{{ $block_item['caption'] }}</div>
            @endif
        @endif
    </div>
@endif
