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



                <div class="form-group col-md-4 col-xl-2">
                    <label>{{ __('Background style') }}</label>
                    <select class="form-select" name="bg_style" id="bg_style" onchange="change_bg_style()">
                        <option @if (($block_extra['bg_style'] ?? null) == 'color') selected @endif value="color">{{ __('Color') }}</option>
                        <option @if (($block_extra['bg_style'] ?? null) == 'image') selected @endif value="image">{{ __('Image') }}</option>
                    </select>
                </div>

                <script>
                    function change_bg_style() {
                        var select = document.getElementById('bg_style');
                        var value = select.options[select.selectedIndex].value;
                        if (value == 'color') {
                            document.getElementById('hidden_div_bg_image').style.display = 'none';
                        } else {
                            document.getElementById('hidden_div_bg_image').style.display = 'block';
                        }
                    }
                </script>



                <div id="hidden_div_bg_image" style="display: @if (($block_extra['bg_style'] ?? null) == 'image') block @else none @endif">
                    <div class="form-group col-xl-2 col-md-3 col-sm-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="cover_dark" name="cover_dark" @if ($block_extra['cover_dark'] ?? null) checked @endif>
                            <label class="form-check-label" for="cover_dark">{{ __('Add dark layer to background cover') }}</label>
                        </div>
                    </div>

                    <div class="form-group col-xl-2 col-md-3 col-sm-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="cover_fixed" name="cover_fixed" @if ($block_extra['cover_fixed'] ?? null) checked @endif>
                            <label class="form-check-label" for="cover_fixed">{{ __('Fixed background') }}</label>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="formFile" class="form-label">{{ __('Image') }}</label>
                        <input class="form-control" type="file" id="formFile" name="bg_image">
                    </div>

                    @if ($block_extra['bg_image'] ?? null)
                        <a target="_blank" href="{{ image($block_extra['bg_image']) }}"><img style="max-width: 300px; max-height: 100px;" src="{{ thumb($block_extra['bg_image']) }}" class="img-fluid mt-2"></a>
                        <input type="hidden" name="existing_bg_image" value="{{ $block_extra['bg_image'] ?? null }}">

                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input type="hidden" name="delete_bg_image_file_code" value="{{ $block_extra['bg_image'] ?? null }}">
                                <input class="form-check-input" type="checkbox" id="delete_bg_image" name="delete_bg_image">
                                <label class="form-check-label" for="delete_bg_image">{{ __('Delete image') }}</label>
                            </div>
                        </div>
                    @endif
                </div>


                <div class="col-md-4 col-lg-3 col-12 form-group">
                    <label>{{ __('Interval duration (in seconds)') }}</label>
                    <input class="form-control" type="number" step="1" min="0" name="delay_seconds" value="{{ $block_extra['delay_seconds'] ?? null }}">
                    <div class="form-text">{{ 'Change the amount of time (in seconds) to delay between automatically cycling to the next item. Leave empty for no delay to next item' }}</div>
                </div>

                <div class="form-group col-xl-3 col-lg-4 col-md-6 mb-3">
                    <label>{{ __('"Read More" button style (if link is set)') }} [<a target="_blank" href="{{ route('admin.theme.buttons.index') }}">{{ __('Manage buttons') }}</a>]</label>
                    <select class="form-select" name="link_btn_id">
                        @foreach ($buttons as $button)
                            <option @if (($block_extra['link_btn_id'] ?? null) == $button->id) selected @endif value="{{ $button->id }}">{{ $button->label }}</option>
                        @endforeach
                    </select>
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
                    <div class="form-group col-xl-3 col-lg-4 col-md-6 mb-0">
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

            </div>

            <div class="form-group">
                <input type="hidden" name="type" value="{{ $block->type }}">
                <input type="hidden" name="referer" value="{{ $referer }}">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <button type="submit" name="submit_return_to_block" value="block" class="btn btn-light ms-3">{{ __('Update and return here') }}</button>
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
               
                @if ($content_array)
                    @for ($i = 0; $i < count($content_array); $i++)
                        <div class="card p-3 bg-light mb-4">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>{{ __('Link title') }}</label>
                                        <input type="text" class="form-control" name="title_{{ $lang->id }}[]" value="{{ $content_array[$i]['title'] ?? null }}">
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>{{ __('Link') }} ({{ __('optional') }})</label>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text" id="basic-addon1">https://</span>
                                            <input type="text" class="form-control" name="url_{{ $lang->id }}[]" value="{{ $content_array[$i]['url'] ?? null }}">
                                        </div>
                                        <div class="form-text text-muted small">{{ __('If you add URL, a button with "Read more" will be added.') }}</div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ __('Content') }}</label>
                                        <textarea class="form-control trumbowyg" rows="8" name="content_{{ $lang->id }}[]">{{ $content_array[$i]['content'] ?? null }}</textarea>
                                        <div class="form-text text-muted small">{{ __('HTML code is allowed') }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="formFile" class="form-label">{{ __('Image') }} ({{ __('optional') }})</label>
                                        <input class="form-control" type="file" id="formFile" name="image_{{ $lang->id }}[]" multiple>
                                        <div class="text-muted small">{{ __('Image file. Maximum 2.5 MB.') }} {{ __('If you do not add an image, the slider text will be displayed in full width') }}</div>

                                        @if ($content_array[$i]['image'] ?? null)
                                            <a target="_blank" href="{{ image($content_array[$i]['image']) }}"><img style="max-width: 300px; max-height: 100px;" src="{{ image($content_array[$i]['image']) }}"
                                                    class="img-fluid mt-2"></a>
                                            <input type="hidden" name="existing_image_{{ $lang->id }}[{{ $i }}]" value="{{ $content_array[$i]['image'] ?? null }}">

                                            <div class="form-group mb-0">
                                                <div class="form-check form-switch">
                                                    <input type="hidden" name="delete_image_file_code_{{ $lang->id }}_{{ $i }}" value="{{ $content_array[$i]['image'] ?? null }}">
                                                    <input class="form-check-input" type="checkbox" id="delete_image_{{ $lang->id }}_{{ $i }}"
                                                        name="delete_image_{{ $lang->id }}_{{ $i }}">
                                                    <label class="form-check-label" for="delete_image_{{ $lang->id }}_{{ $i }}">{{ __('Delete image') }}</label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label>{{ __('Position') }}</label>
                                        <input type="text" class="form-control" name="position_{{ $lang->id }}[]" value="{{ $content_array[$i]['position'] ?? null }}">
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
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label>{{ __('Title') }}</label>
                                <input type="text" class="form-control" name="title_{{ $lang->id }}[]" />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label>{{ __('Link') }} ({{ __('optional') }})</label>
                                <div class="input-group mb-1">
                                    <span class="input-group-text" id="basic-addon1">https://</span>
                                    <input type="text" class="form-control" name="url_{{ $lang->id }}[]">
                                </div>
                                <div class="form-text text-muted small">{{ __('If you add URL, a button with "Read more" will be added.') }}</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>{{ __('Content') }}</label>
                                <textarea class="form-control trumbowyg_{{ $lang->id }}" rows="6" name="content_{{ $lang->id }}[]"></textarea>
                                <div class="form-text text-muted small">{{ __('HTML code is allowed') }}</div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="formFile" class="form-label">{{ __('Change image') }} ({{ __('optional') }})</label>
                                <input class="form-control" type="file" id="formFile" name="image_{{ $lang->id }}[]" multiple>
                                <div class="text-muted small">{{ __('Image file. Maximum 2.5 MB.') }} {{ __('If you do not add an image, the slider text will be displayed in full width') }}</div>
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label>{{ __('Position') }}</label>
                                <input type="text" class="form-control" name="position_{{ $lang->id }}[]" />
                            </div>
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
                                    .attr('data-proforma-index', urlIndex_{{ $lang->id }})
                                    .insertBefore($template);

                                // Update the name attributes
                                $clone
                                    .find('[name="title_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].title_{{ $lang->id }}').end()
                                    .find('[name="url_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].url_{{ $lang->id }}').end()
                                    .find('[name="content_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].content_{{ $lang->id }}').end()
                                    .find('[name="image_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].image_{{ $lang->id }}').end()
                                    .find('[name="position_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].position_{{ $lang->id }}').end()
                                    .find('textarea').trumbowyg();
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
                <input type="hidden" name="existing_bg_image" value="{{ $block_extra['bg_image'] ?? null }}">
                <input type="hidden" name="referer" value="{{ $referer }}">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <button type="submit" name="submit_return_to_block" value="block" class="btn btn-light ms-3">{{ __('Update and return here') }}</button>
            </div>

        </form>

    </div>
    <!-- end card-body -->

</div>
