@php
    if (($is_layout ?? null) == 1) {
        $block_data = layout_block($block['id']);
    } else {
        $block_data = block($block['id']);
    }
@endphp


@if ($block_data->content ?? null)
    @php
        $block_items = unserialize($block_data->content);
        $block_header = unserialize($block_data->header ?? null);

        if (!($block_extra['cols'] ?? null)) {
            $cols = 4;
        } else {
            $cols = $block_extra['cols'];
        }

        if ($cols == 1) {
            $class = 'row-cols-1';
        }
        if ($cols == 2) {
            $class = 'row-cols-1 row-cols-md-2';
        }
        if ($cols == 3) {
            $class = 'row-cols-1 row-cols-sm-2 row-cols-md-3';
        }
        if ($cols == 4) {
            $class = 'row-cols-1 row-cols-sm-2 row-cols-md-4';
        }
        if ($cols == 6) {
            $class = 'row-cols-1 row-cols-sm-2 row-cols-md-4 col-cols-lg-6';
        }
    @endphp

    <div class="block">

        @if ($block_header['add_header'] ?? null)
            <div class="container-xxl">
                <div class="row">
                    <div class="block-header">
                        @if ($block_header['title'] ?? null)
                            <div class="block-header-title">
                                {{ $block_header['title'] ?? null }}
                            </div>
                        @endif

                        @if ($block_header['content'] ?? null)
                            <div class="block-header-content mt-3">
                                {!! $block_header['content'] ?? null !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if (count($block_items) > 0)
            <div class="container-xxl">
                <div class="row {{ $class }} g-4">
                    @foreach ($block_items as $item)
                        @if ($block_extra['horizontal'] ?? null)
                            <div class="col">
                                <div class="card card_{{ $block['id'] }} mb-4 @if ($block_extra['shadow'] ?? null) shadow @endif @if ($block_extra['same_height'] ?? null) h-100 @endif @if (!($block_extra['border_color'] ?? null)) border-0 @endif"
                                    style="@if ($block_extra['bg_color'] ?? null) background-color: {{ $block_extra['bg_color'] }}; @endif @if ($block_extra['border_color'] ?? null) border-color: {{ $block_extra['border_color'] }}; @endif @if ($block_extra['no_border_radius'] ?? null) border-radius: 0; @endif">

                                    <div class="row g-0">

                                        @if ($item['icon'] ?? null)
                                            <div class="card-body p-0">
                                                <div class="icon px-2 py-1 float-start me-2" style="font-size: {{ $block_extra['icon_size'] ?? '2em' }}">{!! $item['icon'] !!}</div>

                                                <div class="p-2">
                                                    @if ($item['title'])
                                                        <div class="title mb-1">
                                                            @if (($item['url'] ?? null) && ($block_extra['link_location'] ?? null) == 'title')
                                                                <a href="https://{{ $item['url'] }}">{{ $item['title'] }}</a>
                                                            @else
                                                                {{ $item['title'] }}
                                                            @endif
                                                        </div>
                                                    @endif
                                                    <p>{{ $item['content'] }}</p>

                                                    @if (($item['url'] ?? null) && ($block_extra['link_location'] ?? null) == 'button')
                                                        <div class="mt-3 @if (($block_extra['link_btn_width'] ?? null) == 'block') d-grid gap-2 @endif">
                                                            <a class="mt-3 btn btn_{{ $block_extra['link_btn_id'] ?? 'primary' }} {{ $block_extra['link_btn_size'] ?? null }}" href="https://{{ $item['url'] }}"
                                                                title="{{ $item['title'] }}">{{ $item['title'] }}</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif ($item['image'] ?? null)
                                            <div class="col-md-4">
                                                <img src="{{ thumb_square($item['image']) }}" class="img-fluid @if ($block_extra['img_full_width'] ?? null) w-100 @endif @if (!$block_extra['no_border_radius'] ?? null) rounded-start @endif"
                                                    alt="{{ $item['title'] ?? $item['image'] }}">
                                            </div>

                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    @if ($item['title'])
                                                        <div class="title mb-3">
                                                            @if (($item['url'] ?? null) && ($block_extra['link_location'] ?? null) == 'title')
                                                                <a href="https://{{ $item['url'] }}">{{ $item['title'] }}</a>
                                                            @else
                                                                {{ $item['title'] }}
                                                            @endif
                                                        </div>
                                                    @endif
                                                    <p>{!! nl2br($item['content']) !!}</p>

                                                    @if (($item['url'] ?? null) && ($block_extra['link_location'] ?? null) == 'button')
                                                        <div class="mt-3 @if (($block_extra['link_btn_width'] ?? null) == 'block') d-grid gap-2 @endif">
                                                            <a class="mt-3 btn btn_{{ $block_extra['link_btn_id'] ?? 'primary' }} {{ $block_extra['link_btn_size'] ?? null }}" href="https://{{ $item['url'] }}"
                                                                title="{{ $item['title'] }}">{{ $item['title'] }}</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="card-body">
                                                @if ($item['title'])
                                                    <div class="title mb-3">
                                                        @if (($item['url'] ?? null) && ($block_extra['link_location'] ?? null) == 'title')
                                                            <a href="https://{{ $item['url'] }}">{{ $item['title'] }}</a>
                                                        @else
                                                            {{ $item['title'] }}
                                                        @endif
                                                    </div>
                                                @endif
                                                <p>{!! nl2br($item['content']) !!}</p>

                                                @if (($item['url'] ?? null) && ($block_extra['link_location'] ?? null) == 'button')
                                                    <div class="mt-3 @if (($block_extra['link_btn_width'] ?? null) == 'block') d-grid gap-2 @endif">
                                                        <a class="mt-3 btn btn_{{ $block_extra['link_btn_id'] ?? 'primary' }} {{ $block_extra['link_btn_size'] ?? null }}" href="https://{{ $item['url'] }}"
                                                            title="{{ $item['title'] }}">{{ $item['title'] }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col">
                                <div class="card card_{{ $block['id'] }} mb-4 @if ($block_extra['shadow'] ?? null) shadow @endif @if ($block_extra['same_height'] ?? null) h-100 @endif @if (!($block_extra['border_color'] ?? null)) border-0 @endif"
                                    style="@if ($block_extra['bg_color'] ?? null) background-color: {{ $block_extra['bg_color'] }}; @endif @if ($block_extra['border_color'] ?? null) border-color: {{ $block_extra['border_color'] }}; @endif @if ($block_extra['no_border_radius'] ?? null) border-radius: 0; @endif">

                                    @if ($item['icon'] ?? null)
                                        <div class="icon px-2 py-1 text-center" style="font-size: {{ $block_extra['icon_size'] ?? '2em' }}">{!! $item['icon'] !!}</div>
                                    @elseif ($item['image'] ?? null)
                                        <img class="card-img-top @if ($block_extra['img_full_width'] ?? null) w-100 @endif" alt="{{ $item['title'] ?? $item['image'] }}" title="{{ $item['title'] ?? $item['image'] }}"
                                            src="{{ thumb($item['image']) }}" @if ($block_extra['no_border_radius'] ?? null) style="border-radius: 0;" @endif>
                                    @endif

                                    <div class="card-body">
                                        @if ($item['title'])
                                            <div class="title mb-2">
                                                @if (($item['url'] ?? null) && ($block_extra['link_location'] ?? null) == 'title')
                                                    <a href="https://{{ $item['url'] }}">{{ $item['title'] }}</a>
                                                @else
                                                    {{ $item['title'] }}
                                                @endif
                                            </div>
                                        @endif

                                        <p>{!! nl2br($item['content']) !!}</p>

                                        @if (($item['url'] ?? null) && ($block_extra['link_location'] ?? null) == 'button')
                                            <div class="mt-3 @if (($block_extra['link_btn_width'] ?? null) == 'block') d-grid gap-2 @endif">
                                                <a class="mt-3 btn btn_{{ $block_extra['link_btn_id'] ?? 'primary' }} {{ $block_extra['link_btn_size'] ?? null }}" href="https://{{ $item['url'] }}"
                                                    title="{{ $item['title'] }}">{{ $item['title'] }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
    </div>
@endif

</div>

<div class="clearfix"></div>
@endif


@if ($block_extra['bg_color_hover'] ?? null)
    <style>
        .card_{{ $block['id'] }}:hover {
            background-color: {{ $block_extra['bg_color_hover'] }} !important;
        }
    </style>
@endif
