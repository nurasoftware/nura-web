@include('admin.includes.trumbowyg-assets')

<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Manage block content') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">

    <div class="card-header">

        <div class="row">

            <div class="col-12">
                <h4 class="card-title">@include('admin.includes.block_type_label', ['type' => $block->type]) - {{ __('Manage block content') }}</h4>
            </div>

        </div>

    </div>


    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            if (($is_footer_block ?? null) == 1) {
                $action = route('admin.theme.footer.block', ['id' => $block->id]);
            } else {
                $action = route('admin.blocks.show', ['id' => $block->id]);
            }
        @endphp

        <form id="updateBlock" method="post" enctype="multipart/form-data" action="{{ $action }}">
            @csrf
            @method('PUT')

            @php
                $block_extra = unserialize($block->extra);
            @endphp

            <div class="card p-3 bg-light mb-4">

                <div class="form-group col-lg-4 col-md-6">
                    <label class="form-label" for="blockLabel">{{ __('Label') }} ({{ __('optional') }})</label>
                    <input class="form-control" type="text" id="blockLabel" name="label" value="{{ $block->label }}">
                    <div class="form-text">{{ __('You can enter a label for this block to easily identify it from multiple blocks of the same type on a page') }}</div>
                </div>

                <div class="form-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="hide" name="hide" @if ($block->hide ?? null) checked @endif>
                        <label class="form-check-label" for="hide">{{ __('Hide block') }}</label>
                    </div>
                    <div class="form-text">{{ __('Hidden blocks are not displayed on website') }}</div>
                </div>

            </div>

            <h5 class="mb-3">{{ __('Block content') }}:</h5>

            @foreach ($content_langs as $lang)
                @if (count($languages) > 1)
                    <h5 class="mb-3">{!! flag($lang->code) !!} {{ $lang->name }}</h5>
                @endif

                @php
                    if (($is_footer_block ?? null) == 1) {
                        $content_array = unserialize($lang->footer_block_content->content ?? null);
                    } elseif (($is_layout_block ?? null) == 1) {
                        $content_array = unserialize($lang->layout_block_content->content ?? null);
                    } else {
                        $content_array = unserialize($lang->block_content->content ?? null);
                    }
                @endphp

                <div class="form-group">
                    <label>{{ __('Title') }} ({{ __('optional') }})</label>
                    <input class="form-control" type="text" name="title_{{ $lang->id }}" value="{{ $content_array['title'] ?? null }}">
                </div>

                <div class="form-group">
                    <label>{{ __('Text content') }}</label>
                    <textarea class="form-control" rows="10" name="content_{{ $lang->id }}">{{ $content_array['content'] ?? null }}</textarea>
                </div>

                <div class="mb-4"></div>

                @if (count($languages) > 1 && !$loop->last)
                    <hr>
                @endif
            @endforeach

            <div class="form-group">
                <input type="hidden" name="type" value="{{ $block->type }}">
                <input type="hidden" name="referer" value="{{ $referer }}">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </div>

        </form>

    </div>
    <!-- end card-body -->

</div>
