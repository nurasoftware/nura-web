@include('admin.theme.includes.import-fonts')
@include('admin.includes.color-picker')

<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.theme') }}">{{ __('Appearance') }}</a></li>
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
                @elseif($style == 'docs')
                    {{ __('Knowledge Base') }}
                @elseif($style == 'forum')
                    {{ __('Support Forum') }}
                @elseif($style == 'articles')
                    {{ __('Articles') }}
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

                <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                    <div class="form-group mb-4">
                        <label>{{ __('Font size') }}</label>
                        <select class="form-select" name="text_size">
                            @foreach ($font_sizes as $font_size)
                                <option @if (($theme_config->text_size ?? null) == $font_size->value) selected @endif @if (!($theme_config->text_size ?? null) && $font_size->value == '1rem') selected @endif value="{{ $font_size->value }}">{{ $font_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 col-md-3  col-xxl-2 col-12">
                        <div class="form-group mb-2">
                            <label>{{ __('Font weight') }}</label>
                            <select class="form-select col-md-6 col-lg-4 col-xl-3" name="font_weight">
                                <option @if (($theme_config->font_weight ?? null) == 'normal') selected @endif value="normal">{{ __('Normal') }}</option>
                                <option @if (($theme_config->font_weight ?? null) == 'bold') selected @endif value="bold">{{ __('Bold') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                        <div class="form-group mb-2">
                            <label>{{ __('Link decoration') }}</label>
                            <select class="form-select col-md-6 col-lg-4 col-xl-3" name="link_decoration">
                                <option @if (($theme_config->link_decoration ?? null) == 'none') selected @endif value="none">{{ __('None') }}</option>
                                <option @if (($theme_config->link_decoration ?? null) == 'underline') selected @endif value="underline">{{ __('Underline') }}</option>
                                <option @if (($theme_config->link_decoration ?? null) == 'dotted') selected @endif value="dotted">{{ __('Dotted') }}</option>
                                <option @if (($theme_config->link_decoration ?? null) == 'dashed') selected @endif value="dashed">{{ __('Dashed') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                        <div class="form-group mb-2">
                            <label>{{ __('Link decoration on hover') }}</label>
                            <select class="form-select col-md-6 col-lg-4 col-xl-3" name="link_hover_decoration">
                                <option @if (($theme_config->link_hover_decoration ?? null) == 'none') selected @endif value="none">{{ __('None') }}</option>
                                <option @if (($theme_config->link_hover_decoration ?? null) == 'underline') selected @endif value="underline">{{ __('Underline') }}</option>
                                <option @if (($theme_config->link_hover_decoration ?? null) == 'dotted') selected @endif value="dotted">{{ __('Dotted') }}</option>
                                <option @if (($theme_config->link_hover_decoration ?? null) == 'dashed') selected @endif value="dashed">{{ __('Dashed') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                        <div class="form-group mb-2">
                            <label>{{ __('Underline line thickness') }}</label>
                            <select class="form-select col-md-6 col-lg-4 col-xl-3" name="link_underline_thickness">
                                <option @if (($theme_config->link_underline_thickness ?? null) == 'auto') selected @endif value="auto">{{ __('Normal') }}</option>
                                <option @if (($theme_config->link_underline_thickness ?? null) == '3px') selected @endif value="3px">{{ __('Bold') }}</option>
                                <option @if (($theme_config->link_underline_thickness ?? null) == '6px') selected @endif value="6px">{{ __('Bolder') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-3 col-xxl-2 col-12">
                        <div class="form-group mb-2">
                            <label>{{ __('Underline offset') }}</label>
                            <select class="form-select col-md-6 col-lg-4 col-xl-3" name="link_underline_offset">
                                <option @if (($theme_config->link_underline_offset ?? null) == 'auto') selected @endif value="auto">{{ __('Normal (no offset)') }}</option>
                                <option @if (($theme_config->link_underline_offset ?? null) == '0.17em') selected @endif value="0.17em">{{ __('Small offset') }}</option>
                                <option @if (($theme_config->link_underline_offset ?? null) == '0.35em') selected @endif value="0.35em">{{ __('Medium offset') }}</option>
                                <option @if (($theme_config->link_underline_offset ?? null) == '0.6em') selected @endif value="0.6em">{{ __('Big offset') }}</option>
                            </select>
                        </div>
                    </div>

                </div>

            </div>

            <hr>

            <div class="fw-bold mb-2">{{ __('Colors') }}</div>

            <div class="row">
                <div class="col-sm-4 col-md-3 col-12">
                    <div class="form-group mb-2">
                        <input id="bg_color" name="bg_color" value="{{ $theme_config->bg_color ?? 'white' }}">
                        <label>{{ __('Background color') }}</label>
                        <div class="mt-1 small"> {{ $theme_config->bg_color ?? 'white' }}</div>
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
                </div>

                <div class="col-sm-4 col-md-3 col-12">
                    <div class="form-group mb-2">
                        <input id="link_color" name="link_color" value="{{ $theme_config->link_color ?? 'blue' }}">
                        <label>{{ __('Links color') }}</label>
                        <div class="mt-1 small"> {{ $theme_config->link_color ?? 'blue' }}</div>
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
                        <input id="bg_color_hover" name="bg_color_hover" value="{{ $theme_config->bg_color_hover ?? 'white' }}">
                        <label>{{ __('Background color (on mouse hover)') }}</label>
                        <div class="mt-1 small"> {{ $theme_config->bg_color_hover ?? 'white' }}</div>
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

                <div class="col-sm-4 col-md-3 col-12">
                    <div class="form-group mb-2">
                        <input id="link_hover_color" name="link_hover_color" value="{{ $theme_config->link_hover_color ?? 'blue' }}">
                        <label>{{ __('Link color on mouse hover') }}</label>
                        <div class="mt-1 small"> {{ $theme_config->link_hover_color ?? 'blue' }}</div>
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

            </div>

            <hr>

            <button type="submit" class="btn btn-primary">{{ __('Update style') }}</button>

        </form>

    </div>
    <!-- end card-body -->

</div>
