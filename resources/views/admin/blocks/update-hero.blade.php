@include('admin.includes.trumbowyg-assets')
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

        <form method="post" enctype="multipart/form-data">
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

                <div id="hidden_div_style" style="display: @if (isset($block_extra['style_id'])) block @else none @endif">
                    <div class="form-group col-xl-3 col-lg-4 col-md-6">
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

                <div class="form-group mb-0 mt-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="use_image" name="use_image" @if ($block_extra['use_image'] ?? null) checked @endif>
                        <label class="form-check-label" for="use_image">{{ __('Use image') }}</label>
                    </div>
                </div>

                <script>
                    $('#use_image').change(function() {
                        select = $(this).prop('checked');
                        if (select) {
                            document.getElementById('hidden_div_image').style.display = 'block';
                            document.getElementById('hidden_div_bg_color').style.display = 'none';
                        } else {
                            document.getElementById('hidden_div_image').style.display = 'none';
                            document.getElementById('hidden_div_bg_color').style.display = 'block';
                        }
                    })
                </script>

                <div id="hidden_div_image" style="display: @if (isset($block_extra['use_image'])) block @else none @endif" class="mt-2">

                    <div class="form-group col-md-4 col-xl-2">
                        <label>{{ __('Image position') }}</label>
                        <select class="form-select" name="image_position" id="image_position" onchange="change_image_position()">
                            <option @if (($block_extra['image_position'] ?? null) == 'top') selected @endif value="top">{{ __('Top (above text content)') }}</option>
                            <option @if (($block_extra['image_position'] ?? null) == 'bottom') selected @endif value="bottom">{{ __('Bottom (below text content)') }}</option>
                            <option @if (($block_extra['image_position'] ?? null) == 'right') selected @endif value="right">{{ __('Right') }}</option>
                            <option @if (($block_extra['image_position'] ?? null) == 'left') selected @endif value="left">{{ __('Left') }}</option>
                            <option @if (($block_extra['image_position'] ?? null) == 'cover') selected @endif value="cover">{{ __('Background cover') }}</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="formFile" class="form-label">{{ __('Image') }}</label>
                        <input class="form-control" type="file" id="formFile" name="image">
                        <div class="text-muted small">{{ __('Image file. Maximum 5 MB.') }}</div>
                    </div>
                    @if ($block_extra['image'] ?? null)
                        <a target="_blank" href="{{ image($block_extra['image']) }}"><img style="max-width: 300px; max-height: 100px;" src="{{ image($block_extra['image']) }}" class="img-fluid"></a>
                        <input type="hidden" name="existing_image" value="{{ $block_extra['image'] ?? null }}">
                    @endif

                    <script>
                        function change_image_position() {
                            var select = document.getElementById('image_position');
                            var value = select.options[select.selectedIndex].value;
                            if (value == 'cover') {
                                document.getElementById('hidden_div_not_cover').style.display = 'none';
                                document.getElementById('hidden_div_cover').style.display = 'block';
                            } else {
                                document.getElementById('hidden_div_not_cover').style.display = 'block';
                                document.getElementById('hidden_div_cover').style.display = 'none';
                            }

                            if (value == 'left' || value == 'right') {
                                document.getElementById('hidden_div_left_right').style.display = 'block';
                                document.getElementById('hidden_div_top_bottom').style.display = 'none';
                            } else {
                                document.getElementById('hidden_div_left_right').style.display = 'none';
                                document.getElementById('hidden_div_top_bottom').style.display = 'block';
                            }
                        }
                    </script>

                    <div id="hidden_div_not_cover" style="display: @if (($block_extra['image_position'] ?? null) == 'cover') none @else block @endif" class="mt-4">
                        <div class="form-group mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="shadow" name="shadow" @if ($block_extra['shadow'] ?? null) checked @endif>
                                <label class="form-check-label" for="shadow">{{ __('Add shadow to image') }}</label>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="img_click" name="img_click" @if ($block_extra['img_click'] ?? null) checked @endif>
                                <label class="form-check-label" for="img_click">{{ __('Click on image to show original size image') }}</label>
                            </div>
                        </div>

                        <div id="hidden_div_left_right" style="display: @if (($block_extra['image_position'] ?? null) == 'left' || ($block_extra['image_position'] ?? null) == 'right') block @else none @endif" class="mt-4">
                            <div class="col-md-4 col-lg-3 col-xl-2 col-12 form-group mt-2">
                                <label class="form-label">{{ __('Image column width') }}</label>
                                <select name="img_col" class="form-select">
                                    <option @if (($block_extra['img_col'] ?? null) == '50') selected @endif value="50">{{ __('1/2 (50%)') }}</option>
                                    <option @if (($block_extra['img_col'] ?? null) == '33') selected @endif value="33">{{ __('1/3 (33%)') }}</option>
                                    <option @if (($block_extra['img_col'] ?? null) == '25') selected @endif value="25">{{ __('1/4 (25%)') }}</option>
                                </select>
                            </div>
                        </div>

                        <div id="hidden_div_top_bottom" style="display: @if (($block_extra['image_position'] ?? null) == 'top' || ($block_extra['image_position'] ?? null) == 'bottom') block @else none @endif" class="mt-4">
                            <div class="col-md-4 col-lg-3 col-xl-2 col-12 form-group mt-2">
                                <label class="form-label">{{ __('Image width') }}</label>
                                <select name="img_container_width" class="form-select">
                                    <option @if (($block_extra['img_container_width'] ?? null) == 'col-12') selected @endif value="col-12">{{ __('Full width') }}</option>
                                    <option @if (($block_extra['img_container_width'] ?? null) == 'col-12 col-md-8 offset-md-2') selected @endif value="col-12 col-md-8 offset-md-2">{{ __('75%') }}</option>
                                    <option @if (($block_extra['img_container_width'] ?? null) == 'col-12 col-md-6 offset-md-3') selected @endif value="col-12 col-md-6 offset-md-3">{{ __('50%') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="hidden_div_cover" style="display: @if (($block_extra['use_image'] ?? null) && ($block_extra['image_position'] ?? null) == 'cover') ) block @else none @endif" class="mt-4">
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
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-4 col-lg-3 col-xl-2 col-12 form-group mt-2">
                        <label>{{ __('Padding (top / bottom)') }}</label>
                        <div class="input-group mb-1">
                            <input type="text" class="form-control" name="padding-y" aria-describedby="addonPadding" value="{{ $block_extra['padding-y'] ?? null }}">
                            <span class="input-group-text" id="addonPadding">px</span>
                        </div>
                        <div class="form-text">{{ __('Leave empty for default padding value') }}</div>
                    </div>
                </div>

                <div class="form-group mb-3 mt-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="shadow_title" name="shadow_title" @if ($block_extra['shadow_title'] ?? null) checked @endif>
                        <label class="form-check-label" for="shadow_title">{{ __('Add shadow to title text') }}</label>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="shadow_content" name="shadow_content" @if ($block_extra['shadow_content'] ?? null) checked @endif>
                        <label class="form-check-label" for="shadow_content">{{ __('Add shadow to content text') }}</label>
                    </div>
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

                <div class="form-group">
                    <label>{{ __('Title') }}</label>
                    <input class="form-control" name="title_{{ $lang->id }}" value="{{ $content_array['title'] ?? null }}">
                </div>

                <div class="form-group">
                    <label>{{ __('Content') }}</label>
                    <textarea class="form-control trumbowyg" name="content_{{ $lang->id }}">{{ $content_array['content'] ?? null }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 col-lg-3 col-xl-2">
                        <div class="form-group">
                            <label>{{ __('Button 1 label') }}</label>
                            <input type="text" class="form-control" name="btn1_label_{{ $lang->id }}" value="{{ $content_array['btn1_label'] ?? null }}">
                            <div class="form-text">{{ __('Leave empty to hide button') }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 col-xl-2">
                        <div class="form-group">
                            <label>{{ __('Button 1 URL') }}</label>
                            <input type="text" class="form-control" name="btn1_url_{{ $lang->id }}" value="{{ $content_array['btn1_url'] ?? null }}">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 col-xl-2">
                        <div class="form-group">
                            <label>{{ __('Button 1 style') }} [<a target="_blank" href="{{ route('admin.theme.buttons.index') }}">{{ __('Manage buttons') }}</a>]</label>
                            <select class="form-select" name="btn1_id_{{ $lang->id }}">
                                @foreach ($buttons as $button)
                                    <option @if (($content_array['btn1_id'] ?? null) == $button->id) selected @endif value="{{ $button->id }}">{{ $button->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 col-xl-2">
                        <div class="form-group">
                            <label>{{ __('Button 1 icon') }} ({{ __('optional') }})</label>
                            <input type="text" class="form-control" name="btn1_icon_{{ $lang->id }}" value="{{ $content_array['btn1_icon'] ?? null }}">
                        </div>
                    </div>                   
                </div>

                <div class="row">
                    <div class="col-md-4 col-lg-3 col-xl-2">
                        <div class="form-group">
                            <label>{{ __('Button 2 label') }}</label>
                            <input type="text" class="form-control" name="btn2_label_{{ $lang->id }}" value="{{ $content_array['btn2_label'] ?? null }}">
                            <div class="form-text">{{ __('Leave empty to hide button') }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 col-xl-2">
                        <div class="form-group">
                            <label>{{ __('Button 2 URL') }}</label>
                            <input type="text" class="form-control" name="btn2_url_{{ $lang->id }}" value="{{ $content_array['btn2_url'] ?? null }}">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 col-xl-2">
                        <div class="form-group">
                            <label>{{ __('Button 2 style') }} [<a target="_blank" href="{{ route('admin.theme.buttons.index') }}">{{ __('Manage buttons') }}</a>]</label>
                            <select class="form-select" name="btn2_id_{{ $lang->id }}">
                                @foreach ($buttons as $button)
                                    <option @if (($content_array['btn2_id'] ?? null) == $button->id) selected @endif value="{{ $button->id }}">{{ $button->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 col-xl-2">
                        <div class="form-group">
                            <label>{{ __('Button 2 icon') }} ({{ __('optional') }})</label>
                            <input type="text" class="form-control" name="btn2_icon_{{ $lang->id }}" value="{{ $content_array['btn2_icon'] ?? null }}">
                        </div>
                    </div>                   
                </div>

                <div class="mb-4"></div>

                @if (count($languages) > 1 && !$loop->last)
                    <hr>
                @endif
            @endforeach


            <div class="form-group">
                <input type="hidden" name="existing_image" value="{{ $block_extra['image'] ?? null }}">
                <input type="hidden" name="type" value="{{ $block->type }}">
                <input type="hidden" name="referer" value="{{ $referer }}">

                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <button type="submit" name="submit_return_to_block" value="block" class="btn btn-light ms-3">{{ __('Update and return here') }}</button>
            </div>

        </form>

    </div>
    <!-- end card-body -->

</div>
