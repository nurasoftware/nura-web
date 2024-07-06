@php
    $block_content = block($block['id']);
@endphp

@if ($block_content->content ?? null)
    @php
        $data = unserialize($block_content->content);
    @endphp

    @if (count($data) > 0)
        <div @if (($block_extra['bg_style'] ?? null) == 'image' && ($block_extra['bg_image'] ?? null)) style="display: block; justify-content: center; align-items: center; overflow: hidden; background-image: @if ($block_extra['cover_dark'] ?? null) linear-gradient(rgb(0 0 0 / 50%), rgb(0 0 0 / 50%)), @endif
            url('{{ str_replace('\\', '/', image($block_extra['bg_image'])) }}'); background-size: cover; @if ($block_extra['cover_fixed'] ?? null) background-attachment: fixed @endif;" @endif>

            <div class="container-xxl">
                <div class="block style_{{ $block_extra['style_id'] ?? null }}">
                    <div class="row">

                        <div id="carousel_{{ $block['id'] }}" class="carousel slide" data-bs-ride="carousel"
                            @if ($block_extra['delay_seconds'] ?? null) data-bs-interval="{{ $block_extra['delay_seconds'] * 1000 }}" @else data-bs-interval="false" @endif>

                            <div class="carousel-inner">

                                @foreach ($data as $slide)
                                    <div class="carousel-item @if ($loop->first) active @endif">
                                        <div class="row">
                                            @if ($slide['image'])
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 d-lg-block d-none">
                                                    <img src="{{ image($slide['image']) }}" alt="{{ $slide['title'] }}" class="d-block w-100 block-slider-img">
                                                </div>
                                            @endif

                                            <div class="@if (!$slide['image']) col-12 @else col-xl-6 col-lg-6 col-md-12 col-md-12 col-12 @endif">
                                                <div class="title mb-5 mt-4 @if ($block_extra['shadow_title'] ?? null) text-shadow @endif">
                                                    {{ $slide['title'] }}
                                                </div>
                                                <div class="block-slider-content block-slider-truncate-text @if ($block_extra['shadow_content'] ?? null) text-shadow @endif">
                                                    {!! $slide['content'] !!}
                                                </div>
                                                @if ($slide['url'])
                                                    <a class="mt-4 btn btn_{{ $block_extra['link_btn_id'] ?? 'primary' }}" href="https://{{ $slide['url'] }}" title="{{ $slide['title'] }}">{{ __('Read More') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel_{{ $block['id'] }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">{{ __('Previous') }}</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel_{{ $block['id'] }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">{{ __('Next') }}</span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    @endif
@endif
