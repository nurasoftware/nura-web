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
                    <h4 class="card-title">{{ __('Manage block content') }} ({{ __('Video') }})</h4>
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

            <form method="post">
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

                    <div class="form-group col-xl-2 col-md-3 col-sm-4 mb-0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="full_width_responsive" name="full_width_responsive" @if ($block_extra['full_width_responsive'] ?? null) checked @endif>
                            <label class="form-check-label" for="full_width_responsive">{{ __('Force video full width and responsive') }}</label>
                        </div>
                    </div>

                </div>


                <h5 class="mb-3">{{ __('Block content') }}:</h5>

                @foreach ($content_langs as $lang)

                    @if (count($langs) > 1)
                        <h5 class="mb-3">{!! flag($lang->code) !!} {{ $lang->name }}</h5>
                    @endif

                    @php
                        $header_array = unserialize($lang->block_header);
                    @endphp

                    <div class="card p-3 bg-light mb-4">
                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="add_header_{{ $lang->id }}" name="add_header_{{ $lang->id }}" @if ($header_array['add_header'] ?? null) checked @endif>
                                <label class="form-check-label" for="add_header_{{ $lang->id }}">{{ __('Add header content') }}</label>
                            </div>
                        </div>

                        <script>
                            $('#add_header_{{ $lang->id }}').change(function() {
                                select = $(this).prop('checked');
                                if (select)
                                    document.getElementById('hidden_div_header_{{ $lang->id }}').style.display = 'block';
                                else
                                    document.getElementById('hidden_div_header_{{ $lang->id }}').style.display = 'none';
                            })
                        </script>

                        <div id="hidden_div_header_{{ $lang->id }}" style="display: @if ($header_array['add_header'] ?? null) block @else none @endif" class="mt-2">
                            <div class="form-group">
                                <label>{{ __('Header title') }}</label>
                                <input class="form-control" name="header_title_{{ $lang->id }}" value="{{ $header_array['title'] ?? null }}">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Header content') }}</label>
                                <textarea class="form-control trumbowyg" name="header_content_{{ $lang->id }}">{{ $header_array['content'] ?? null }}</textarea>
                            </div>
                        </div>
                    </div>

                    @php
                        $content_array = unserialize($lang->block_content);
                    @endphp

                    <div class="form-group">
                        <label>{{ __('Insert video embed code') }}</label>
                        <textarea class="form-control" rows="6" name="embed_{{ $lang->id }}">{{ $content_array['embed'] ?? null }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>{{ __('Caption') }} ({{ __('optional') }})</label>
                        <input class="form-control" type="text" name="caption_{{ $lang->id }}" value="{{ $content_array['caption'] ?? null }}">
                    </div>

                    <div class="mb-4"></div>                   

                    @if (count($langs) > 1 && !$loop->last)<hr>@endif

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

