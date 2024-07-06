@include('admin.includes.color-picker')

<div class="card">

    <div class="card-header">

        <div class="row">

            <div class="col-12">
                @include('admin.theme.includes.menu-theme')
            </div>

        </div>

    </div>


    <div class="card-body">

        @if ($theme_settings ?? null)
            <nav class="nav nav-tabs mb-3" id="myTab" role="tablist">
                @foreach ($theme_settings as $key => $theme_settings_tab)
                    <a class="nav-item nav-link @if (($tab ?? null) == $key) active @endif @if ((!$tab ?? null) && $loop->first) active @endif"
                        href="{{ route('admin.themes.show', ['slug' => $slug, 'tab' => $key]) }}">{{ $key }}</a>

                    @if ((!$tab ?? null) && $loop->first)
                        @php $tab = $key @endphp
                    @endif
                @endforeach
            </nav>

            @if ($message = Session::get('success'))
                <div class="alert alert-success py-2">
                    @if ($message == 'updated')
                        <div class="fw-bold">{{ __('Updated') }}</div>
                        @if (($tab ?? null) == 'core-style' || ($tab ?? null) == 'core-navs')
                            <i class="bi bi-exclamation-circle"></i> {{ __("Note: if you don't see any changes on website, you can try to reload the website using CTRL+F5 or clear browser cache.") }}
                        @endif
                    @endif
                </div>
            @endif

            <form method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if (array_key_exists($tab, $theme_settings))

                    @foreach ($theme_settings[$tab] as $tab_key => $item)
                        @if (($item['type'] ?? null) == 'boolean')
                            <div class="form-group mb-3">
                                <div class="form-check form-switch">
                                    <input type='hidden' value='' name='{{ $tab_key }}'>
                                    <input class="form-check-input" type="checkbox" id="{{ $tab_key }}" name="{{ $tab_key }}"
                                        @if ($this_theme_config->$tab_key ?? null) checked @elseif (($item['default'] ?? null) === true) checked @endif>
                                    <label class="form-check-label" for="{{ $tab_key }}">{{ $item['label'] ?? null }}</label>
                                </div>
                                @if ($item['description'] ?? null)
                                    <div class="form-text">{{ $item['description'] ?? null }}</div>
                                @endif
                            </div>
                        @endif

                        @if (($item['type'] ?? null) == 'input')
                            <div class="form-group mb-3">
                                <label class="form-check-label" for="{{ $tab_key }}">{{ $item['label'] ?? null }}</label>
                                <input class="form-control" type="text" id="{{ $tab_key }}" name="{{ $tab_key }}" value="{{ $this_theme_config->$tab_key ?? null }}">
                                @if ($item['description'] ?? null)
                                    <div class="form-text">{{ $item['description'] ?? null }}</div>
                                @endif
                            </div>
                        @endif

                        @if (($item['type'] ?? null) == 'textarea')
                            <div class="form-group mb-3">
                                <label class="form-check-label" for="{{ $tab_key }}">{{ $item['label'] ?? null }}</label>
                                <textarea class="form-control" rows="4" id="{{ $tab_key }}" name="{{ $tab_key }}">{{ $this_theme_config->$tab_key ?? null }}</textarea>
                                @if ($item['description'] ?? null)
                                    <div class="form-text">{{ $item['description'] ?? null }}</div>
                                @endif
                            </div>
                        @endif

                        @if (($item['type'] ?? null) == 'color')
                            <div class="form-group mb-4">
                                <input id="{{ $tab_key }}" name="{{ $tab_key }}" value="{{ $this_theme_config->$tab_key ?? ($item['default'] ?? 'white') }}">
                                <label>{{ $item['label'] ?? null }}</label>
                                <div class="mt-1 small"> {{ $this_theme_config->$tab_key ?? ($item['default'] ?? 'white') }}</div>
                                <script>
                                    $('#{{ $tab_key }}').spectrum({
                                        type: "color",
                                        showInput: true,
                                        showInitial: true,
                                        showAlpha: false,
                                        showButtons: false,
                                        allowEmpty: false,
                                    });
                                </script>
                                @if ($item['description'] ?? null)
                                    <div class="form-text">{{ $item['description'] ?? null }}</div>
                                @endif
                            </div>
                        @endif
                    @endforeach


                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                @endif
            </form>
        @else
            {{ __("This theme doesn't contain any configurable settings") }}
        @endif


        {{--
        @if ($theme_tab_view ?? null)
            <form method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include("{$theme_tab_view}")
                <hr>
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </form>
        @endif
        --}}

    </div>
    <!-- end card-body -->

</div>
