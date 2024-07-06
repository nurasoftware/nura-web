@php
    $block_data = block($block['id']);
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

        if ($cols == 2) {
            $class = 'col-sm-6 col-12';
        }
        if ($cols == 3) {
            $class = 'col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12';
        }
        if ($cols == 4) {
            $class = 'col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12';
        }
        if ($cols == 6) {
            $class = 'col-xl-2 col-lg-2 col-md-4 col-sm-6 col-12';
        }
    @endphp

    <div class="block text-center">
        <div class="row">

            @if ($block_header['add_header'] ?? null)
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
            @endif

            @if (count($block_items) > 0)

                @if ($block_extra['masonry_layout'] ?? null)


                    <div class="row g-0">
                        <div id="masonry">
                            <div class="grid-sizer"></div>

                            @foreach ($block_items as $item)
                                <div class="grid-item g-0">
                                    <a data-fancybox="gallery-{{ $block['id'] }}" class="gallery" href="{{ image($item['image']) }}"><img
                                            class="img-fluid @if ($block_extra['shadow'] ?? null) shadow @endif @if ($block_extra['rounded'] ?? null) rounded @endif" alt="{{ $item['title'] ?? $item['image'] }}"
                                            title="{{ $item['title'] ?? $item['image'] }}" src="{{ image($item['image']) }}"></a>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @else
                    @foreach ($block_items as $item)
                        @if ($item['image'])
                            <div class="{{ $class }} mb-4">
                                <div class="block-gallery-image-box">

                                    @if ($item['url'])
                                        <a href="{{ $item['url'] }}"><img class="img-fluid @if ($block_extra['shadow'] ?? null) shadow @endif @if ($block_extra['rounded'] ?? null) rounded @endif"
                                                alt="{{ $item['title'] ?? $item['image'] }}" title="{{ $item['title'] ?? $item['image'] }}" src="{{ thumb($item['image']) }}"></a>
                                    @else
                                        <a data-fancybox="gallery-{{ $block['id'] }}" data-caption="{{ $item['caption'] ?? null }}" class="gallery" href="{{ image($item['image']) }}"><img
                                                class="img-fluid @if ($block_extra['rounded'] ?? null) rounded @endif @if ($block_extra['shadow'] ?? null) shadow @endif @if ($block_extra['rounded'] ?? null) rounded @endif"
                                                alt="{{ $item['title'] ?? $item['image'] }}" title="{{ $item['title'] ?? $item['image'] }}" src="{{ thumb($item['image']) }}"></a>
                                    @endif
                                </div>

                                @if ($item['caption'] ?? null)
                                    <div class="caption">{{ $item['caption'] }}</div>
                                @endif
                            </div>
                        @endif
                    @endforeach

                @endif
            @endif

        </div>
    </div>

    <div class="clearfix"></div>
@endif


@if ($block_extra['masonry_layout'] ?? null)
    @php
        if (!($block_extra['masonry_cols'] ?? null)) {
            $grid_item_width = '25'; // 4 cols (25%)
        } else {
            $grid_item_width = round(100 / $block_extra['masonry_cols'], 2);
        }
        $calc = $grid_item_width . '% - ' . ($block_extra['masonry_gutter'] ?? 0) . 'px';
    @endphp

    <style>
        .grid-sizer,
        .grid-item {
            width: calc({{ $calc }});
        }

        .grid-item {
            margin-bottom: {{ $block_extra['masonry_gutter'] ?? 0 }}px;
        }

        .grid {
            margin-bottom: 10px
        }
    </style>
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

    <script>
        imagesLoaded(document.querySelector('#masonry'), function(instance) {

            var elem = document.querySelector('#masonry');
            var msnry = new Masonry(elem, {
                // options
                itemSelector: '.grid-item',
                columnWidth: '.grid-sizer',
                percentPosition: true,
                gutter: {{ $block_extra['masonry_gutter'] ?? 0 }}
            });
        });
    </script>
@endif
