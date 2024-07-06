@php
$block_data = block($block->id);
@endphp

@if ($block_data->content ?? null)
    @php
        $block_items = unserialize($block_data->content);
        $block_header = unserialize($block_data->header ?? null);
    @endphp

    <div class="block">
        <div class="row">

            @if ($block_header['add_header'] ?? null)
                <div class="block-header">
                    @if ($block_header['title'] ?? null)
                        <div class="block-header-title">
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


            @if (count($block_items) > 0)

                @if ($block_extra['display_style'] == 'list')
                    <ul>
                @endif

                @foreach ($block_items as $item)
                    @if ($block_extra['display_style'] == 'list')
                        <li>
                    @endif

                    @if ($item['icon'])
                        {!! $item['icon'] !!}
                    @endif
                    <a href="{{ $item['url'] }}" title="{{ $item['title'] }}" @if ($block_extra['new_tab'] ?? null) target="_blank" @endif>{{ $item['title'] }}</a>

                    @if ($block_extra['display_style'] == 'list')
                        </li>
                    @else
                        <span class="me-3"></span>
                    @endif
                @endforeach

            @endif

        </div>
    </div>

@endif
