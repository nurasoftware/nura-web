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

                @foreach ($block_items as $item)
                    <div class="{{ $class }} mb-5">
                        @if (($block_extra['use_image'] ?? null) && $item['image'])
                            <div class="d-flex justify-content-center mb-3">
                                <img src="{{ thumb_square($item['image']) }}" class="rounded-circle shadow-1-strong" width="160" height="160" alt="{{ $item['name'] ?? $item['image'] }}" />
                            </div>
                        @endif

                        <div class="fw-bold text-center title">{{ $item['name'] }}</div>

                        @if ($item['subtitle'] ?? null)
                            <div class="text-center subtitle mb-2">{{ $item['subtitle'] }}</div>
                        @endif

                        @if ($block_extra['use_star_rating'] ?? null)
                            <div class="d-flex justify-content-center mb-2">
                                @if ($item['rating'] == 1)
                                    <i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star text-warning me-1"></i><i class="bi bi-star text-warning me-1"></i><i class="bi bi-star text-warning me-1"></i><i
                                        class="bi bi-star text-warning me-1"></i>
                                @elseif($item['rating'] == 1.5)
                                    <i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-half text-warning me-1"></i><i class="bi bi-star text-warning me-1"></i><i
                                        class="bi bi-star text-warning me-1"></i><i class="bi bi-star text-warning me-1"></i>
                                @elseif($item['rating'] == 2)
                                    <i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star text-warning me-1"></i><i
                                        class="bi bi-star text-warning me-1"></i><i class="bi bi-star text-warning me-1"></i>
                                @elseif($item['rating'] == 2.5)
                                    <i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-half text-warning me-1"></i><i
                                        class="bi bi-star text-warning me-1"></i><i class="bi bi-star text-warning me-1"></i>
                                @elseif($item['rating'] == 3)
                                    <i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i><i
                                        class="bi bi-star text-warning me-1"></i><i class="bi bi-star text-warning me-1"></i>
                                @elseif($item['rating'] == 3.5)
                                    <i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i><i
                                        class="bi bi-star-half text-warning me-1"></i><i class="bi bi-star text-warning me-1"></i>
                                @elseif($item['rating'] == 4)
                                    <i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i><i
                                        class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star text-warning me-1"></i>
                                @elseif($item['rating'] == 4.5)
                                    <i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i><i
                                        class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-half text-warning me-1"></i>
                                @else
                                    <i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i><i
                                        class="bi bi-star-fill text-warning me-1"></i><i class="bi bi-star-fill text-warning me-1"></i>
                                @endif
                            </div>
                        @endif

                        <p class="px-xl-3">
                            <i class="bi bi-quote pe-1"></i> {!! nl2br($item['testimonial']) !!}
                        </p>

                    </div>
                @endforeach

            @endif

        </div>
    </div>

    <div class="clearfix"></div>
@endif
