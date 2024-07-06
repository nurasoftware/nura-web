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


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        @if ($message == 'updated')
            {{ __('Updated') }}
        @endif
        @if ($message == 'created')
            {{ __('Block added. You can add content below.') }}
        @endif
    </div>
@endif


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

        <form id="updateBlock" method="post" enctype="multipart/form-data">
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

                <div class="form-group mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="shadow" name="shadow" @if ($block_extra['shadow'] ?? null) checked @endif>
                        <label class="form-check-label" for="shadow">{{ __('Add shadow to images') }}</label>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="rounded" name="rounded" @if ($block_extra['rounded'] ?? null) checked @endif>
                        <label class="form-check-label" for="rounded">{{ __('Add rounded corners to image') }}</label>
                    </div>
                </div>

                <div id="hidden_div_cols" style="display: @if (isset($block_extra['masonry_layout'])) none @else block @endif" class="mt-1">
                    <div class="form-group col-md-4 col-xl-3">
                        <label>{{ __('Select columns (number of images per row)') }}</label>
                        <select class="form-select" name="cols">
                            <option @if (($block_extra['cols'] ?? null) == 2) selected @endif value="2">2</option>
                            <option @if (($block_extra['cols'] ?? null) == 3) selected @endif value="3">3</option>
                            <option @if (($block_extra['cols'] ?? null) == 4 || is_null($block_extra['cols'] ?? null)) selected @endif value="4">4</option>
                            <option @if (($block_extra['cols'] ?? null) == 6) selected @endif value="6">6</option>
                        </select>
                        <div class="form-text">{{ __('This is the maximum number of images per row for larger displays. For smaller displays, the columns are resized automatically.') }}</div>
                    </div>
                </div>

                <div class="form-group mb-1">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="masonry_layout" name="masonry_layout" @if ($block_extra['masonry_layout'] ?? null) checked @endif>
                        <label class="form-check-label" for="masonry_layout">{{ __('Use Masonry to arange images') }}</label>
                    </div>
                    <div class="text-muted">{{ __('It works by placing elements in optimal position based on available vertical space.') }}</div>
                    <div class="text-muted">{{ __('This option works fine if you have many images (multiple lines). Note: caption text is not displayed') }}</div>
                </div>

                <script>
                    $('#masonry_layout').change(function() {
                        select = $(this).prop('checked');
                        if (select) {
                            document.getElementById('hidden_div_masonry').style.display = 'block';
                            document.getElementById('hidden_div_cols').style.display = 'none';
                        } else {
                            document.getElementById('hidden_div_masonry').style.display = 'none';
                            document.getElementById('hidden_div_cols').style.display = 'block';
                        }
                    })
                </script>

                <div id="hidden_div_masonry" style="display: @if (isset($block_extra['masonry_layout'])) block @else none @endif" class="mt-1">
                    <div class="form-group col-md-4 col-xl-3">
                        <label>{{ __('Select columns (number of images per row)') }}</label>
                        <select class="form-select" name="masonry_cols">
                            <option @if (($block_extra['masonry_cols'] ?? null) == 3) selected @endif value="3">3</option>
                            <option @if (($block_extra['masonry_cols'] ?? null) == 4 || is_null($block_extra['masonry_cols'] ?? null)) selected @endif value="4">4</option>
                            <option @if (($block_extra['masonry_cols'] ?? null) == 5) selected @endif value="5">5</option>
                            <option @if (($block_extra['masonry_cols'] ?? null) == 6) selected @endif value="6">6</option>
                        </select>
                        <div class="form-text">{{ __('This is the maximum number of images per row for larger displays. For smaller displays, the columns are resized automatically.') }}</div>
                    </div>

                    <div class="form-group col-md-4 col-xl-3">
                        <label>{{ __('Gutter') }}</label>
                        <select class="form-select" name="masonry_gutter">
                            <option @if (($block_extra['masonry_gutter'] ?? null) == 0 || is_null($block_extra['masonry_gutter'] ?? null)) selected @endif value="0">{{ __('No margin') }}</option>
                            <option @if (($block_extra['masonry_gutter'] ?? null) == 10) selected @endif value="10">{{ __('Small margin') }}</option>
                            <option @if (($block_extra['masonry_gutter'] ?? null) == 30) selected @endif value="30">{{ __('Large margin') }}</option>
                        </select>
                        <div class="form-text">{{ __('Gutter is the margin between images.') }}</div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="use_custom_style" name="use_custom_style" @if ($block_extra['style_id'] ?? null) checked @endif>
                        <label class="form-check-label" for="use_custom_style">{{ __('Use custom style for this section') }}</label>
                    </div>
                </div>

                <script>
                    $('#use_custom_style').change(function() {
                        select = $(this).prop('checked');
                        if (select)
                            document.getElementById('hidden_div_style').style.display = 'block';
                        else
                            document.getElementById('hidden_div_style').style.display = 'none';
                    })
                </script>

                <div id="hidden_div_style" style="display: @if (isset($block_extra['style_id'])) block @else none @endif" class="mt-2">
                    <div class="form-group col-lg-4 col-md-6 mb-0">
                        <label>{{ __('Select custom style') }} [<a class="fw-bold" target="_blank" href="{{ route('admin.theme.styles.index') }}">{{ __('manage custom styles') }}</a>]</label>
                        <select class="form-select" id="style_id" name="style_id" value="@if (isset($block_extra['style_id'])) {{ $block_extra['style_id'] }} @else #fbf7f0 @endif">
                            <option value="">-- {{ __('select') }} --</option>
                            @foreach ($styles as $style)
                                <option @if (($block_extra['style_id'] ?? null) == $style->id) selected @endif value="{{ $style->id }}">{{ $style->label }}</option>
                            @endforeach
                        </select>
                        @if (count($styles) == 0)
                            <div class="small text-info mt-1">{{ __("You don't have custom styles created") }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-group mt-4 mb-0">
                    <input type="hidden" name="type" value="{{ $block->type }}">
                    <input type="hidden" name="referer" value="{{ $referer }}">
                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    <button type="submit" name="submit_return_to_block" value="block" class="btn btn-light ms-3">{{ __('Update and return here') }}</button>
                </div>
            </div>

            <h5 class="mb-3">{{ __('Block content') }}:</h5>

            @foreach ($content_langs as $lang)
                @if (count($languages) > 1)
                    <h5 class="mb-3">{!! flag($lang->code) !!} {{ $lang->name }}</h5>
                @endif

                @php
                    $header_array = unserialize($lang->block_content->header ?? null);
                    $content_array = unserialize($lang->block_content->content ?? null);      
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

              
                @if ($content_array)
                    @for ($i = 0; $i < count($content_array); $i++)
                        <div class="card p-3 bg-light mb-4">
                            <div class="row">

                                <div class="form-group col-md-4 col-sm-6">
                                    <label for="formFile" class="form-label">{{ __('Change image') }}</label>
                                    <input class="form-control" type="file" id="formFile" name="image_{{ $lang->id }}[]" multiple>
                                    <div class="text-muted small">{{ __('Image file. Maximum 2.5 MB.') }}</div>

                                    @if ($content_array[$i]['image'] ?? null)
                                        <a target="_blank" href="{{ image($content_array[$i]['image']) }}"><img style="max-width: 300px; max-height: 100px;" src="{{ image($content_array[$i]['image']) }}"
                                                class="img-fluid mt-2"></a>
                                        <input type="hidden" name="existing_image_{{ $lang->id }}[]" value="{{ $content_array[$i]['image'] ?? null }}">
                                        <div class="text-muted small">{{ __('Image file. Maximum 2.5 MB.') }}</div>
                                    @endif
                                </div>

                                <div class="form-group col-md-3 col-sm-6">
                                    <label>{{ __('Title (used as "alt" tag)') }}</label>
                                    <input type="text" class="form-control" name="title_{{ $lang->id }}[]" value="{{ $content_array[$i]['title'] ?? null }}">
                                </div>

                                <div class="form-group col-md-3 col-sm-6">
                                    <label>{{ __('Caption') }} ({{ __('optional') }})</label>
                                    <input class="form-control" type="text" name="caption_{{ $lang->id }}[]" value="{{ $content_array[$i]['caption'] ?? null }}">
                                </div>

                                <div class="form-group col-md-2 col-sm-6">
                                    <label>{{ __('Position') }}</label>
                                    <input type="text" class="form-control" name="position_{{ $lang->id }}[]" value="{{ $content_array[$i]['position'] ?? null }}">
                                </div>

                                <div class="form-group col-md-4 col-sm-6">
                                    <label>{{ __('URL') }} ({{ __('optional') }})</label>
                                    <input type="text" class="form-control" name="url_{{ $lang->id }}[]" value="{{ $content_array[$i]['url'] ?? null }}">
                                    <div class="text-muted small">{{ __('If you add URL, the link is opened, instead images gallery player.') }}</div>
                                </div>

                                <div class="form-group mb-0">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="delete_image_file_code_{{ $lang->id }}_{{ $i }}" value="{{ $content_array[$i]['image'] ?? null }}">
                                        <input class="form-check-input" type="checkbox" id="delete_image_{{ $lang->id }}_{{ $i }}" name="delete_image_{{ $lang->id }}_{{ $i }}">
                                        <label class="form-check-label" for="delete_image_{{ $lang->id }}_{{ $i }}">{{ __('Delete image') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4"></div>
                    @endfor
                @endif


                <!-- The template for adding new item -->
                <div class="form-group hide" id="ItemTemplate_{{ $lang->id }}">
                    <div class="row">

                        <div class="form-group col-md-4 col-sm-6">
                            <label for="formFile" class="form-label">{{ __('Change image') }}</label>
                            <input class="form-control" type="file" id="formFile" name="image_{{ $lang->id }}[]" multiple>
                        </div>

                        <div class="form-group col-md-3 col-sm-6">
                            <label>{{ __('Title (used as "alt" tag)') }}</label>
                            <input type="text" class="form-control" name="title_{{ $lang->id }}[]" />
                        </div>

                        <div class="form-group col-md-3 col-sm-6">
                            <label>{{ __('Caption') }} ({{ __('optional') }})</label>
                            <input class="form-control" type="text" name="caption_{{ $lang->id }}[]">
                        </div>

                        <div class="form-group col-md-2 col-sm-6">
                            <label>{{ __('Position') }}</label>
                            <input type="text" class="form-control" name="position_{{ $lang->id }}[]" />
                        </div>

                        <div class="form-group col-md-4 col-sm-6">
                            <label>{{ __('URL') }} ({{ __('optional') }})</label>
                            <input type="text" class="form-control" name="url_{{ $lang->id }}[]">
                            <div class="text-muted small">{{ __('If you add URL, the link is opened, instead images gallery player.') }}</div>
                        </div>
                    </div>
                    <div class="mb-4"></div>
                </div>

                <div class="mb-3 mt-3">
                    <button type="button" class="btn btn-gear addButton_{{ $lang->id }}"><i class="bi bi-plus-circle"></i> {{ __('Add item') }} </button>
                </div>

                <script>
                    $(document).ready(function() {
                        urlIndex_{{ $lang->id }} = 0;
                        $('#updateBlock')
                            // Add button click handler
                            .on('click', '.addButton_{{ $lang->id }}', function() {
                                urlIndex_{{ $lang->id }}++;
                                var $template = $('#ItemTemplate_{{ $lang->id }}'),
                                    $clone = $template
                                    .clone()
                                    .removeClass('hide')
                                    .removeAttr('id')
                                    .attr('data-block-index', urlIndex_{{ $lang->id }})
                                    .insertBefore($template);

                                // Update the name attributes
                                $clone
                                    .find('[name="title_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].title_{{ $lang->id }}').end()
                                    .find('[name="image_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].image_{{ $lang->id }}').end()
                                    .find('[name="caption_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].caption_{{ $lang->id }}').end()
                                    .find('[name="position_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].position_{{ $lang->id }}').end()
                                    .find('[name="url_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].url_{{ $lang->id }}').end();
                            })

                    });
                </script>

                <div class="mb-4"></div>               

                @if (count($languages) > 1 && !$loop->last)
                    <hr>
                @endif
            @endforeach


            <div class="form-group">
                <input type="hidden" name="type" value="{{ $block->type }}">
                <input type="hidden" name="referer" value="{{ $referer }}">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <button type="submit" name="submit_return_to_block" value="block" class="btn btn-light ms-3">{{ __('Update and return here') }}</button>
            </div>

        </form>

    </div>
    <!-- end card-body -->

</div>
