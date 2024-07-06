@switch($block->type)
    @case('custom')
        @include('web.blocks.footer.custom')
    @break

    @case('editor')
        @include('web.blocks.footer.editor')
    @break

    @case('image')
        @include('web.blocks.footer.image')
    @break

    @case('links')
        <div class="px-4">
            @include('web.blocks.footer.links')
        </div>
    @break

    @case('text')
        @include('web.blocks.footer.text')
    @break
@endswitch
