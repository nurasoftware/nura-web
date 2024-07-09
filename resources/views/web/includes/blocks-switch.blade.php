@if (!($block['type'] == 'slider' || $block['type'] == 'map' || $block['type'] == 'hero'))
    <div class="@if ($page->container_fluid ?? null) container-fluid @else @if (!($is_post_content ?? null) == 1)container-xxl @endif @endif">
@endif

@include('web.blocks.' . $block['type'])

@if (!($block['type'] == 'slider' || $block['type'] == 'map' || $block['type'] == 'hero'))
    </div>
@endif
