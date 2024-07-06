<div id="footer">    
    <!-- ======= Primary Footer ======= -->
    <div class="style_footer">
        <div class="@if ($theme_config->website_container_fluid ?? null) container-fluid @else container-xxl @endif">
            @php
                $footer_columns = $config->theme_footer_columns ?? 1;
            @endphp

            @include("web.includes.footer-{$footer_columns}-col", ['footer' => 'primary'])
        </div>
    </div>

    @if ($config->theme_footer2_show ?? null)    
        <!-- ======= Secondary Footer ======= -->
        <div class="style_footer2">
            <div class="@if ($theme_config->website_container_fluid ?? null) container-fluid @else container-xxl @endif">
                @php
                    $footer_columns = $config->theme_footer2_columns ?? 1;
                @endphp
                @include("web.includes.footer-{$footer_columns}-col", ['footer' => 'secondary'])
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

<!-- Fancybox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>

@if (($config->addthis_code ?? null) && ($config->addthis_code_enabled ?? null))
    <!-- Addthis tools -->
    {!! $config->addthis_code ?? null !!}
@endif

{!! $config->template_global_footer_code ?? null !!}

