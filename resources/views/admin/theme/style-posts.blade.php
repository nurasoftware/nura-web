@include('admin.theme.includes.import-fonts')
@include('admin.includes.color-picker')

<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.theme') }}">{{ __('Template') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.theme.styles.index') }}">{{ __('Styles') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Update style') }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">

    <div class="card-header">

        <div class="row">

            <div class="col-12">
                @include('admin.theme.includes.menu-theme')
            </div>

        </div>

    </div>


    <div class="card-body">

        <div class="mt-2 mb-4 fs-5">{{ __('Update style') }}: <b>
                @if ($style == 'global')
                    {{ __('Global Style') }}
                @elseif($style == 'nav')
                    {{ __('Navigation') }}
                @elseif($style == 'nav_dropdown')
                    {{ __('Navigation Dropdown') }}
                @elseif($style == 'footer')
                    {{ __('Footer') }}
                @elseif($style == 'footer2')
                    {{ __('Secondary Footer') }}                
                @elseif($style == 'posts')
                    {{ __('Posts') }}
                @else
                    {{ $style }}
                @endif
            </b>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                @if ($message == 'updated')
                    <div class="fw-bold">{{ __('Updated') }}</div>
                    <i class="bi bi-exclamation-circle"></i>
                    {{ __("Note: If you don't see any changes on website, you can try to reload the website using CTRL+F5 or clear browser cache.") }}
                @endif
                @if ($message == 'created')
                    <h4 class="alert-heading">{{ __('Created') }}</h4>
                @endif
            </div>
        @endif


        <form method="post">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="fw-bold fs-5 mb-1">{{ __('Posts global style') }}</div>

                <div class="row">
                    <div class="col-sm-6 col-md-6 col-12 mb-2">
                        <div class="form-group">
                            <label>{{ __('Font family for post article content') }}</label>
                            <select class="form-select" name="font_family">
                                @foreach ($fonts as $font)
                                    <option @if (($templateConfig->font_family ?? null) == $font->import . '|' . $font->value) selected @endif value="{{ $font->import . '|' . $font->value }}" style="font-size: 1.6em; font-family: {{ $font->value }};">
                                        [{{ $font->name }}]
                                        Almost before we knew it, we had left the ground.</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-12 mb-2">
                        <div class="form-group">
                            <label>{{ __('Font family for titles and headings') }}</label>
                            <select class="form-select" name="font_family_headings">
                                @foreach ($fonts as $font)
                                    <option @if (($templateConfig->font_family_headings ?? null) == $font->import . '|' . $font->value) selected @endif value="{{ $font->import . '|' . $font->value }}" style="font-size: 1.6em; font-family: {{ $font->value }};">
                                        [{{ $font->name }}]
                                        Almost before we knew it, we had left the ground.</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 col-md-3 col-12">
                        <div class="form-group mb-2">
                            <input id="text_color" name="text_color" value="{{ $templateConfig->text_color ?? 'black' }}">
                            <label>{{ __('Text color') }}</label>
                            <div class="mt-1 small"> {{ $templateConfig->text_color ?? 'black' }}</div>
                            <script>
                                $('#text_color').spectrum({
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

                    <div class="col-sm-4 col-md-3 col-12">
                        <div class="form-group mb-2">
                            <input id="link_color" name="link_color" value="{{ $templateConfig->link_color ?? '#3365cc' }}">
                            <label>{{ __('Link color') }}</label>
                            <div class="mt-1 small"> {{ $templateConfig->link_color ?? '#3365cc' }}</div>
                            <script>
                                $('#link_color').spectrum({
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


                    <div class="col-sm-4 col-md-3 col-12">
                        <div class="form-group mb-2">
                            <input id="link_hover_color" name="link_hover_color" value="{{ $templateConfig->link_hover_color ?? '#3365cc' }}">
                            <label>{{ __('Link color on mouse hover') }}</label>
                            <div class="mt-1 small"> {{ $templateConfig->link_hover_color ?? '#3365cc' }}</div>
                            <script>
                                $('#link_hover_color').spectrum({
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

                    <div class="col-sm-4 col-md-3 col-12">
                        <div class="form-group mb-2">
                            <input id="light_color" name="light_color" value="{{ $templateConfig->light_color ?? 'grey' }}">
                            <label>{{ __('Light color (used for meta details)') }}</label>
                            <div class="mt-1 small"> {{ $templateConfig->light_color ?? 'grey' }}</div>
                            <script>
                                $('#light_color').spectrum({
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

                    <div class="col-sm-4 col-md-3 col-12">
                        <div class="form-group mb-2">
                            <input id="search_bar_bg_color" name="search_bar_bg_color" value="{{ $templateConfig->search_bar_bg_color ?? '#f2efef' }}">
                            <label>{{ __('Search bar background color') }}</label>
                            <div class="mt-1 small"> {{ $templateConfig->search_bar_bg_color ?? '#f2efef' }}</div>
                            <script>
                                $('#search_bar_bg_color').spectrum({
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
                </div>
            </div>

            <hr>


            <div class="fw-bold fs-5 mb-1">{{ __('Posts list') }}</div>
            <div class="text-muted small mb-3">{{ __('Posts listings from main posts page and categories pages.') }}</div>

            <div class="row">
                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-4">
                        <label>{{ __('Title font size') }}</label>
                        <select class="form-select" name="listing_title_size">
                            @foreach ($font_sizes as $font_size)
                                <option @if (($templateConfig->listing_title_size ?? null) == $font_size->value) selected @endif @if (!($templateConfig->listing_title_size ?? null) && $font_size->value == '1.3rem') selected @endif value="{{ $font_size->value }}">{{ $font_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-4">
                        <label>{{ __('Text size (post summary)') }}</label>
                        <select class="form-select" name="listing_text_size">
                            @foreach ($font_sizes as $font_size)
                                <option @if (($templateConfig->listing_text_size ?? null) == $font_size->value) selected @endif @if (!($templateConfig->listing_text_size ?? null) && $font_size->value == '1rem') selected @endif value="{{ $font_size->value }}">{{ $font_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-4">
                        <label>{{ __('Text size (meta: icon, date, author, views...)') }}</label>
                        <select class="form-select" name="listing_meta_size">
                            @foreach ($font_sizes as $font_size)
                                <option @if (($templateConfig->listing_meta_size ?? null) == $font_size->value) selected @endif @if (!($templateConfig->listing_meta_size ?? null) && $font_size->value == '0.9rem') selected @endif value="{{ $font_size->value }}">{{ $font_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-sm-4 col-md-3  col-xxl-2 col-12">
                    <div class="form-group mb-2">
                        <label>{{ __('Font weight (post title)') }}</label>
                        <select class="form-select col-md-6 col-lg-4 col-xl-3" name="listing_title_font_weight">
                            <option @if (($templateConfig->listing_title_font_weight ?? null) == 'normal') selected @endif value="normal">{{ __('Normal') }}</option>
                            <option @if (($templateConfig->listing_title_font_weight ?? null) == 'bold') selected @endif value="bold">{{ __('Bold') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3  col-xxl-2 col-12">
                    <div class="form-group mb-2">
                        <label>{{ __('Font weight (post summary)') }}</label>
                        <select class="form-select col-md-6 col-lg-4 col-xl-3" name="listing_text_font_weight">
                            <option @if (($templateConfig->listing_text_font_weight ?? null) == 'normal') selected @endif value="normal">{{ __('Normal') }}</option>
                            <option @if (($templateConfig->listing_text_font_weight ?? null) == 'bold') selected @endif value="bold">{{ __('Bold') }}</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-2">
                        <label>{{ __('Link decoration') }}</label>
                        <select class="form-select col-md-6 col-lg-4 col-xl-3" name="listing_link_decoration">
                            <option @if (($templateConfig->listing_link_decoration ?? null) == 'none') selected @endif value="none">{{ __('None') }}</option>
                            <option @if (($templateConfig->listing_link_decoration ?? null) == 'underline') selected @endif value="underline">{{ __('Underline') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-2">
                        <label>{{ __('Link decoration on hover') }}</label>
                        <select class="form-select col-md-6 col-lg-4 col-xl-3" name="listing_link_hover_decoration">
                            <option @if (($templateConfig->listing_link_hover_decoration ?? null) == 'none') selected @endif value="none">{{ __('None') }}</option>
                            <option @if (($templateConfig->listing_link_hover_decoration ?? null) == 'underline') selected @endif value="underline">{{ __('Underline') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-2">
                        <label>{{ __('Underline line thickness') }}</label>
                        <select class="form-select col-md-6 col-lg-4 col-xl-3" name="listing_link_underline_thickness">
                            <option @if (($templateConfig->listing_link_underline_thickness ?? null) == 'auto') selected @endif value="auto">{{ __('Normal') }}</option>
                            <option @if (($templateConfig->listing_link_underline_thickness ?? null) == '3px') selected @endif value="3px">{{ __('Bold') }}</option>
                            <option @if (($templateConfig->listing_link_underline_thickness ?? null) == '6px') selected @endif value="6px">{{ __('Bolder') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-2">
                        <label>{{ __('Underline offset') }}</label>
                        <select class="form-select col-md-6 col-lg-4 col-xl-3" name="listing_link_underline_offset">
                            <option @if (($templateConfig->listing_link_underline_offset ?? null) == 'auto') selected @endif value="auto">{{ __('Normal (no offset)') }}</option>
                            <option @if (($templateConfig->listing_link_underline_offset ?? null) == '0.17rem') selected @endif value="0.17em">{{ __('Small offset') }}</option>
                            <option @if (($templateConfig->listing_link_underline_offset ?? null) == '0.35rem') selected @endif value="0.35em">{{ __('Medium offset') }}</option>
                            <option @if (($templateConfig->listing_link_underline_offset ?? null) == '0.6rem') selected @endif value="0.6em">{{ __('Big offset') }}</option>
                        </select>
                    </div>
                </div>
            </div>


            <hr>



            <div class="fw-bold fs-5 mb-1">{{ __('Post details page') }}</div>

            <div class="row">
                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-4">
                        <label>{{ __('Title font size') }}</label>
                        <select class="form-select" name="post_title_size">
                            @foreach ($font_sizes as $font_size)
                                <option @if (($templateConfig->post_title_size ?? null) == $font_size->value) selected @endif @if (!($templateConfig->post_title_size ?? null) && $font_size->value == '2rem') selected @endif value="{{ $font_size->value }}">{{ $font_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3  col-xxl-2 col-12">
                    <div class="form-group mb-2">
                        <label>{{ __('Title font weight') }}</label>
                        <select class="form-select col-md-6 col-lg-4 col-xl-3" name="post_title_font_weight">
                            <option @if (($templateConfig->post_title_font_weight ?? null) == 'normal') selected @endif value="normal">{{ __('Normal') }}</option>
                            <option @if (($templateConfig->post_title_font_weight ?? null) == 'bold') selected @endif value="bold">{{ __('Bold') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3  col-xxl-2 col-12">
                    <div class="form-group mb-2">
                        <label>{{ __('Title line height') }}</label>
                        <select class="form-select col-md-6 col-lg-4 col-xl-3" name="post_title_line_height">
                            <option @if (($templateConfig->post_title_line_height ?? null) == '1') selected @endif value="1">{{ __('Normal') }}</option>
                            <option @if (($templateConfig->post_title_line_height ?? null) == '1.2') selected @endif value="1.2">{{ __('Medium') }}</option>
                            <option @if (($templateConfig->post_title_line_height ?? null) == '1.5') selected @endif value="1.5">{{ __('Large') }}</option>
                            <option @if (($templateConfig->post_title_line_height ?? null) == '1.8') selected @endif value="1.8">{{ __('Extra large') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3  col-xxl-2 col-12">
                    <div class="form-group mb-2">
                        <label>{{ __('Summary font weight') }}</label>
                        <select class="form-select col-md-6 col-lg-4 col-xl-3" name="post_summary_font_weight">
                            <option @if (($templateConfig->post_summary_font_weight ?? null) == 'normal') selected @endif value="normal">{{ __('Normal') }}</option>
                            <option @if (($templateConfig->post_summary_font_weight ?? null) == 'bold') selected @endif value="bold">{{ __('Bold') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-4">
                        <label>{{ __('Meta text size (icon, date, author, views...)') }}</label>
                        <select class="form-select" name="post_meta_size">
                            @foreach ($font_sizes as $font_size)
                                <option @if (($templateConfig->post_meta_size ?? null) == $font_size->value) selected @endif @if (!($templateConfig->post_meta_size ?? null) && $font_size->value == '0.9rem') selected @endif value="{{ $font_size->value }}">{{ $font_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-4">
                        <label>{{ __('Article text size') }}</label>
                        <select class="form-select" name="post_text_size">
                            @foreach ($font_sizes as $font_size)
                                <option @if (($templateConfig->post_text_size ?? null) == $font_size->value) selected @endif @if (!($templateConfig->post_text_size ?? null) && $font_size->value == '1rem') selected @endif value="{{ $font_size->value }}">{{ $font_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3  col-xxl-2 col-12">
                    <div class="form-group mb-2">
                        <label>{{ __('Article line height') }}</label>
                        <select class="form-select col-md-6 col-lg-4 col-xl-3" name="post_line_height">
                            <option @if (($templateConfig->post_line_height ?? null) == '1.1') selected @endif value="1.1">{{ __('Normal') }}</option>
                            <option @if (($templateConfig->post_line_height ?? null) == '1.4') selected @endif value="1.4">{{ __('Medium') }}</option>
                            <option @if (($templateConfig->post_line_height ?? null) == '1.8') selected @endif value="1.8">{{ __('Large') }}</option>
                            <option @if (($templateConfig->post_line_height ?? null) == '2.2') selected @endif value="2.2">{{ __('Extra large') }}</option>
                        </select>
                    </div>
                </div>

            </div>

            <hr>

            <div class="fw-bold fs-5 mb-1">{{ __('Categories links list') }}</div>

            <div class="row">
                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-4">
                        <label>{{ __('Links font size') }}</label>
                        <select class="form-select" name="categs_font_size">
                            @foreach ($font_sizes as $font_size)
                                <option @if (($templateConfig->categs_font_size ?? null) == $font_size->value) selected @endif @if (!($templateConfig->categs_font_size ?? null) && $font_size->value == '1.2rem') selected @endif value="{{ $font_size->value }}">{{ $font_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 col-md-3  col-xxl-2 col-12">
                    <div class="form-group mb-2">
                        <label>{{ __('Links font weight') }}</label>
                        <select class="form-select col-md-6 col-lg-4 col-xl-3" name="categs_font_weight">
                            <option @if (($templateConfig->categs_font_weight ?? null) == 'normal') selected @endif value="normal">{{ __('Normal') }}</option>
                            <option @if (($templateConfig->categs_font_weight ?? null) == 'bold') selected @endif value="bold">{{ __('Bold') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-md-3 col-12">
                    <div class="form-group mb-4">
                        <input id="categs_link_color" name="categs_link_color" value="{{ $templateConfig->tags_link_color ?? '#3365cc' }}">
                        <label>{{ __('Link color') }}</label>
                        <div class="mt-1 small"> {{ $templateConfig->categs_link_color ?? '#3365cc' }}</div>
                        <script>
                            $('#categs_link_color').spectrum({
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

                <div class="col-sm-4 col-md-3 col-12">
                    <div class="form-group mb-2">
                        <input id="categs_link_hover_color" name="categs_link_hover_color" value="{{ $templateConfig->categs_link_hover_color ?? '#3365cc' }}">
                        <label>{{ __('Link color on mouse hover') }}</label>
                        <div class="mt-1 small"> {{ $templateConfig->categs_link_hover_color ?? '#3365cc' }}</div>
                        <script>
                            $('#categs_link_hover_color').spectrum({
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
            </div>


            <div class="fw-bold fs-6 mb-1">{{ __('Box settings (apply only if layout for categories links is set to boxes)') }}</div>
            <div class="row">
                <div class="col-sm-4 col-md-3 col-12">
                    <div class="form-group mb-4">
                        <input id="categs_box_bg_color" name="categs_box_bg_color" value="{{ $templateConfig->categs_box_bg_color ?? '#F3F1EF' }}">
                        <label>{{ __('Box background color') }}</label>
                        <div class="mt-1 small"> {{ $templateConfig->categs_box_bg_color ?? '#F3F1EF' }}</div>
                        <script>
                            $('#categs_box_bg_color').spectrum({
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

                <div class="col-sm-4 col-md-3 col-12">
                    <div class="form-group mb-2">
                        <input id="categs_box_bg_hover_color" name="categs_box_bg_hover_color" value="{{ $templateConfig->categs_box_bg_hover_color ?? '#dbd8d4' }}">
                        <label>{{ __('Box color on mouse hover') }}</label>
                        <div class="mt-1 small"> {{ $templateConfig->categs_card_bg_hover_color ?? '#dbd8d4' }}</div>
                        <script>
                            $('#categs_box_bg_hover_color').spectrum({
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
            </div>

            <hr>

            <div class="fw-bold fs-5 mb-1">{{ __('Posts tags') }}</div>

            <div class="row">
                <div class="col-sm-4 col-md-3 col-12">
                    <div class="form-group mb-4">
                        <input id="tags_link_color" name="tags_link_color" value="{{ $templateConfig->tags_link_color ?? '#3365cc' }}">
                        <label>{{ __('Link color') }}</label>
                        <div class="mt-1 small"> {{ $templateConfig->tags_link_color ?? '#3365cc' }}</div>
                        <script>
                            $('#tags_link_color').spectrum({
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

                <div class="col-sm-4 col-md-3 col-12">
                    <div class="form-group mb-2">
                        <input id="tags_link_hover_color" name="tags_link_hover_color" value="{{ $templateConfig->tags_link_hover_color ?? '#3365cc' }}">
                        <label>{{ __('Link color on mouse hover') }}</label>
                        <div class="mt-1 small"> {{ $templateConfig->tags_link_hover_color ?? '#3365cc' }}</div>
                        <script>
                            $('#tags_link_hover_color').spectrum({
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
            </div>


            <div class="fw-bold fs-6 mb-1">{{ __('Box settings (apply only if layout for tags is set to boxes)') }}</div>
            <div class="row">
                <div class="col-sm-4 col-md-3 col-12">
                    <div class="form-group mb-4">
                        <input id="tags_card_bg_color" name="tags_card_bg_color" value="{{ $templateConfig->tags_card_bg_color ?? '#F3F1EF' }}">
                        <label>{{ __('Box background color') }}</label>
                        <div class="mt-1 small"> {{ $templateConfig->tags_card_bg_color ?? '#F3F1EF' }}</div>
                        <script>
                            $('#tags_card_bg_color').spectrum({
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

                <div class="col-sm-4 col-md-3 col-12">
                    <div class="form-group mb-2">
                        <input id="tags_card_bg_hover_color" name="tags_card_bg_hover_color" value="{{ $templateConfig->tags_card_bg_hover_color ?? '#dbd8d4' }}">
                        <label>{{ __('Box color on mouse hover') }}</label>
                        <div class="mt-1 small"> {{ $templateConfig->tags_card_bg_hover_color ?? '#dbd8d4' }}</div>
                        <script>
                            $('#tags_card_bg_hover_color').spectrum({
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
            </div>

            <hr>

            <div class="fw-bold fs-5 mb-1">{{ __('Custom text') }}</div>
            <div class="text-muted small mb-3">
                {{ __('Style for custom text from posts main page You can manage custom text in posts settings in template builder.') }}
                <a href="{{ route('admin.theme', ['module' => 'posts']) }}">{{ __('Go to posts template builder') }}</a>
            </div>

            <div class="row">
                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-4">
                        <label>{{ __('Title font size') }}</label>
                        <select class="form-select" name="custom_title_size">
                            @foreach ($font_sizes as $font_size)
                                <option @if (($templateConfig->custom_title_size ?? null) == $font_size->value) selected @endif @if (!($templateConfig->custom_title_size ?? null) && $font_size->value == '1.3rem') selected @endif value="{{ $font_size->value }}">{{ $font_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-4">
                        <label>{{ __('Content font size') }}</label>
                        <select class="form-select" name="custom_text_size">
                            @foreach ($font_sizes as $font_size)
                                <option @if (($templateConfig->custom_text_size ?? null) == $font_size->value) selected @endif @if (!($templateConfig->custom_text_size ?? null) && $font_size->value == '1rem') selected @endif value="{{ $font_size->value }}">{{ $font_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 col-md-3 col-12">
                    <div class="form-group mb-2">
                        <input id="custom_content_color" name="custom_content_color" value="{{ $templateConfig->custom_content_color ?? 'black' }}">
                        <label>{{ __('Custom text color') }}</label>
                        <div class="mt-1 small"> {{ $templateConfig->custom_content_color ?? 'black' }}</div>
                        <script>
                            $('#custom_content_color').spectrum({
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
            </div>

            <hr>

            <button type="submit" class="btn btn-primary">{{ __('Update style') }}</button>

        </form>

    </div>
    <!-- end card-body -->

</div>
