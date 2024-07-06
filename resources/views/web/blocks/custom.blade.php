@php
$block_data = block($block->id);
@endphp

@if ($block_data->content ?? null)
    <div class="@if(($module ?? null) == 'docs') @else container-xxl @endif">
        <div class="block">
            {!! $block_data->content !!}
        </div>
    </div>
@endif
