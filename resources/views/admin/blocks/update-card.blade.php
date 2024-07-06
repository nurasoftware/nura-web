@include('admin.includes.color-picker')

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
                        <label class="form-check-label" for="shadow">{{ __('Add shadow to cards') }}</label>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="no_border_radius" name="no_border_radius" @if ($block_extra['no_border_radius'] ?? null) checked @endif>
                        <label class="form-check-label" for="no_border_radius">{{ __('Disable border radius') }}</label>
                    </div>
                    <div class="form-text">{{ __('By default, cards have rounded border. Check to disable border rounding.') }}</div>
                </div>

                <div class="form-group mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="horizontal" name="horizontal" @if ($block_extra['horizontal'] ?? null) checked @endif>
                        <label class="form-check-label" for="horizontal">{{ __('Horizontal cards content') }}</label>
                    </div>
                    <div class="form-text">{{ __('If checked, card text content will be atfter the image. If not checked, card text content will be below the image.') }}</div>
                </div>

                <div class="form-group mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="same_height" name="same_height" @if ($block_extra['same_height'] ?? null) checked @endif>
                        <label class="form-check-label" for="same_height">{{ __('Cards have same height') }}</label>
                    </div>
                    <div class="form-text">{{ __('If cards have different heights (depending on content), force all cards to have the height of the tallest card') }}</div>
                </div>

                <div class="form-group mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="img_full_width" name="img_full_width" @if ($block_extra['img_full_width'] ?? null) checked @endif>
                        <label class="form-check-label" for="img_full_width">{{ __('Force cards images to be full width') }}</label>
                    </div>
                    <div class="form-text">{{ __('If card image is smaller, force image to grow to 100% width of the parent div') }}</div>
                </div>

                <div class="form-group col-md-4 col-xl-3">
                    <label>{{ __('Select columns (number of cards per row)') }}</label>
                    <select class="form-select" name="cols">
                        <option @if (($block_extra['cols'] ?? null) == 1) selected @endif value="1">1</option>
                        <option @if (($block_extra['cols'] ?? null) == 2) selected @endif value="2">2</option>
                        <option @if (($block_extra['cols'] ?? null) == 3) selected @endif value="3">3</option>
                        <option @if (($block_extra['cols'] ?? null) == 4 || is_null($block_extra['cols'] ?? null)) selected @endif value="4">4</option>
                        <option @if (($block_extra['cols'] ?? null) == 6) selected @endif value="6">6</option>
                    </select>
                    <div class="form-text">{{ __('This is the maximum number of cards per row for larger displays. For smaller displays, the cards are resized automatically.') }}</div>
                </div>

                <div class="form-group">
                    <input class="form-control form-control-color" name="bg_color" id="bg_color" value="{{ $block_extra['bg_color'] ?? 'white' }}">
                    <label>{{ __('Card background color') }}</label>
                    <script>
                        $('#bg_color').spectrum({
                            type: "color",
                            showInput: true,
                            showInitial: true,
                            showAlpha: false,
                            showButtons: false,
                            allowEmpty: false,
                        });
                    </script>
                </div>

                <div class="form-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="use_border" name="use_border" @if ($block_extra['border_color'] ?? null) checked @endif>
                        <label class="form-check-label" for="use_border">{{ __('Show cards border') }}</label>
                    </div>
                </div>

                <script>
                    $('#use_border').change(function() {
                        select = $(this).prop('checked');
                        if (select)
                            document.getElementById('hidden_div_border').style.display = 'block';
                        else
                            document.getElementById('hidden_div_border').style.display = 'none';
                    })
                </script>

                <div id="hidden_div_border" style="display: @if (isset($block_extra['border_color'])) block @else none @endif" class="mt-2">
                    <div class="form-group mb-4">
                        <input class="form-control form-control-color" name="border_color" id="border_color" value="{{ $block_extra['border_color'] ?? 'grey' }}">
                        <label>{{ __('Card border color') }}</label>
                        <script>
                            $('#border_color').spectrum({
                                type: "color",
                                showInput: true,
                                showInitial: true,
                                showAlpha: false,
                                showButtons: false,
                                allowEmpty: false,
                            });
                        </script>
                    </div>
                </div>


                <div class="form-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="use_bg_color_hover" name="use_bg_color_hover" @if ($block_extra['bg_color_hover'] ?? null) checked @endif>
                        <label class="form-check-label" for="use_bg_color_hover">{{ __('Use custom background color on mouse hover the card') }}</label>
                    </div>
                </div>

                <script>
                    $('#use_bg_color_hover').change(function() {
                        select = $(this).prop('checked');
                        if (select)
                            document.getElementById('hidden_div_bg_color_hover').style.display = 'block';
                        else
                            document.getElementById('hidden_div_bg_color_hover').style.display = 'none';
                    })
                </script>

                <div id="hidden_div_bg_color_hover" style="display: @if (isset($block_extra['bg_color_hover'])) block @else none @endif" class="mt-2">
                    <div class="form-group mb-4">
                        <input class="form-control form-control-color" name="bg_color_hover" id="bg_color_hover" value="{{ $block_extra['bg_color_hover'] ?? 'grey' }}">
                        <label>{{ __('Card background color on mouse hover') }}</label>
                        <script>
                            $('#bg_color_hover').spectrum({
                                type: "color",
                                showInput: true,
                                showInitial: true,
                                showAlpha: false,
                                showButtons: false,
                                allowEmpty: false,
                            });
                        </script>
                    </div>
                </div>

                <div class="form-group col-xl-3 col-lg-4 col-md-6 mb-3">
                    <label>{{ __('Select icon size (if you use icons)') }}</label>
                    <select class="form-select" id="icon_size" name="icon_size">
                        @foreach ($font_sizes as $selected_font_size_title)
                            <option @if (($block_extra['icon_size'] ?? null) == $selected_font_size_title->value) selected @endif @if (!($block_extra['icon_size'] ?? null) && $selected_font_size_title->value == '2em') selected @endif value="{{ $selected_font_size_title->value }}">
                                {{ $selected_font_size_title->name }}</option>
                        @endforeach
                        <option @if (($block_extra['icon_size'] ?? null) == '15em') selected @endif value="15em">1500%</option>
                        <option @if (($block_extra['icon_size'] ?? null) == '20em') selected @endif value="20em">2000%</option>
                    </select>
                </div>

                <div class="row">
                    <div class="form-group col-xl-3 col-lg-4 col-md-6 mb-3">
                        <label>{{ __('Link location (if card link is set)') }}</label>
                        <select class="form-select" name="link_location">
                            <option @if (($block_extra['link_location'] ?? null) == 'title') selected @endif value="title">{{ __('Add link on title') }}</option>
                            <option @if (($block_extra['link_location'] ?? null) == 'button') selected @endif value="button">{{ __('Add button link') }}</option>
                        </select>
                    </div>

                    <div class="form-group col-xl-3 col-lg-4 col-md-6 mb-3">
                        <label>{{ __('Link button style (if button link is set)') }} [<a target="_blank" href="{{ route('admin.theme.buttons.index') }}">{{ __('Manage buttons') }}</a>]</label>
                        <select class="form-select" name="link_btn_id">
                            @foreach ($buttons as $button)
                                <option @if (($block_extra['link_btn_id'] ?? null) == $button->id) selected @endif value="{{ $button->id }}">{{ $button->label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-xl-3 col-lg-4 col-md-6 mb-3">
                        <label>{{ __('Button size (if button link is set)') }}</label>
                        <select class="form-select" name="link_btn_size">
                            <option @if (($block_extra['link_btn_size'] ?? null) == '') selected @endif value="">{{ __('Normal') }}</option>
                            <option @if (($block_extra['link_btn_size'] ?? null) == 'btn-lg') selected @endif value="btn-lg">{{ __('Large') }}</option>
                            <option @if (($block_extra['link_btn_size'] ?? null) == 'btn-sm') selected @endif value="btn-sm">{{ __('Small') }}</option>
                        </select>
                    </div>

                    <div class="form-group col-xl-3 col-lg-4 col-md-6 mb-3">
                        <label>{{ __('Button width (if button link is set)') }}</label>
                        <select class="form-select" name="link_btn_width">
                            <option @if (($block_extra['link_btn_width'] ?? null) == '') selected @endif value="">{{ __('Normal') }}</option>
                            <option @if (($block_extra['link_btn_width'] ?? null) == 'block') selected @endif value="block">{{ __('Full width') }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mt-2 mb-0">
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


            <h5 class="mb-3 mt-5">{{ __('Block content') }}:</h5>

            @foreach ($content_langs as $lang)
                @if (count($languages) > 1 && $block_module != 'posts')
                    <h5 class="mb-3">{!! flag($lang->code) !!} {{ $lang->name }}</h5>
                @endif

                @php
                    $header_array = unserialize($lang->block_content->header ?? null);
                    $content_array = unserialize($lang->block_content->content ?? null);
                @endphp

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


                @if ($content_array)
                    @php $iteration = 1; @endphp
                    @for ($i = 0; $i < count($content_array); $i++)
                        <div class="card p-3 bg-light mb-4">
                            <div class="fw-bold mb-3">{{ __('Card') }} #{{ $iteration }}</div>
                            <div class="row">

                                <div class="form-group col-md-4 col-sm-6">
                                    <label>{{ __('Title') }} ({{ __('required') }})</label>
                                    <input type="text" class="form-control" name="title_{{ $lang->id }}[]" value="{{ $content_array[$i]['title'] ?? null }}">
                                </div>

                                <div class="form-group col-md-4 col-sm-6">
                                    <label for="formFile" class="form-label">{{ __('Image') }} ({{ __('optional') }})</label>
                                    <input class="form-control" type="file" id="formFile" name="image_{{ $lang->id }}[]" multiple>
                                    <div class="text-muted small">{{ __('Image file. Maximum 2.5 MB.') }}</div>

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

                                <div class="form-group col-md-4 col-sm-6">
                                    <label>{{ __('Icon') }} ({{ __('optional') }})</label>
                                    <input type="text" class="form-control" name="icon_{{ $lang->id }}[]" value="{{ $content_array[$i]['icon'] ?? null }}">
                                    <div class="form-text text-muted small">{{ __('Input icon code to show an icon image') }}</div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Content') }} ({{ __('optional') }})</label>
                                    <textarea class="form-control" rows="3" name="content_{{ $lang->id }}[]">{{ $content_array[$i]['content'] ?? null }}</textarea>
                                </div>


                                <div class="form-group col-md-2 col-sm-6">
                                    <label>{{ __('Position') }}</label>
                                    <input type="text" class="form-control" name="position_{{ $lang->id }}[]" value="{{ $content_array[$i]['position'] ?? null }}">
                                </div>

                                <div class="form-group col-md-4 col-sm-6">
                                    <label>{{ __('Link') }} ({{ __('optional') }})</label>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text" id="basic-addon1">https://</span>
                                        <input type="text" class="form-control" name="url_{{ $lang->id }}[]" value="{{ $content_array[$i]['url'] ?? null }}">
                                    </div>
                                    <div class="form-text text-muted small">{{ __('Add a link to title or button') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4"></div>
                        @php $iteration++ @endphp
                    @endfor
                @endif

                <!-- The template for adding new item -->
                <div class="form-group hide" id="ItemTemplate_{{ $lang->id }}">
                    <div class="row">

                        <div class="form-group col-md-4 col-sm-6">
                            <label>{{ __('Title') }} ({{ __('required') }})</label>
                            <input type="text" class="form-control" name="title_{{ $lang->id }}[]" />
                        </div>

                        <div class="form-group col-md-4 col-sm-6">
                            <label for="formFile" class="form-label">{{ __('Image') }} ({{ __('optional') }})</label>
                            <input class="form-control" type="file" id="formFile" name="image_{{ $lang->id }}[]" multiple>
                            <div class="text-muted small">{{ __('Image file. Maximum 2.5 MB.') }}</div>
                        </div>

                        <div class="form-group col-md-4 col-sm-6">
                            <label>{{ __('Icon') }} ({{ __('optional') }})</label>
                            <input type="text" class="form-control" name="icon_{{ $lang->id }}[]" />
                            <div class="text-muted small">{{ __('Input icon code to show an icon image') }}</div>
                        </div>

                        <div class="form-group col-12">
                            <label>{{ __('Content') }} ({{ __('optional') }})</label>
                            <textarea class="form-control" rows="3" name="content_{{ $lang->id }}[]"></textarea>
                        </div>

                        <div class="form-group col-md-2 col-sm-6">
                            <label>{{ __('Position') }}</label>
                            <input type="text" class="form-control" name="position_{{ $lang->id }}[]" />
                        </div>

                        <div class="form-group col-md-4 col-sm-6">
                            <label>{{ __('Link') }} ({{ __('optional') }})</label>
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">https://</span>
                                <input type="text" class="form-control" name="url_{{ $lang->id }}[]" />
                            </div>
                            <div class="form-text text-muted small">{{ __('Add a link to title or button') }}</div>
                        </div>
                    </div>
                    <div class="mb-4"></div>
                </div>

                <div class="mb-3 mt-3">
                    <button type="button" class="btn btn-gear addButton_{{ $lang->id }}"><i class="bi bi-plus-circle"></i> {{ __('Add card') }} </button>
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
                                    .find('[name="url_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].url_{{ $lang->id }}').end()
                                    .find('[name="image_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].image_{{ $lang->id }}').end()
                                    .find('[name="content_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].content_{{ $lang->id }}').end()
                                    .find('[name="position_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].position_{{ $lang->id }}').end()
                                    .find('[name="icon_{{ $lang->id }}"]').attr('name', 'updateBlock[' + urlIndex_{{ $lang->id }} + '].icon_{{ $lang->id }}').end()
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
