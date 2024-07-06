<div class="row">

    @for ($footer_col = 1; $footer_col <= 2; $footer_col++)
        <div class="col-md-6 col-12">
            @foreach (footer_blocks($footer, $footer_col) as $block)
                @php
                    $block_extra = unserialize($block->extra);
                @endphp

                <div class="section" id="footer-block-{{ $block->id }}">
                    @include('web.includes.footer-blocks-switch')
                </div>
            @endforeach
        </div>
    @endfor

</div>
