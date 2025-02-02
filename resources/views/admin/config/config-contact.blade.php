@include('admin.includes.trumbowyg-assets')

<div class="page-title">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.config', ['module' => 'email']) }}">{{ __('Configuration') }}</a></li>
                </ol>
            </nav>
        </div>
    </div>
</div>


<div class="card">

    <div class="card-header">

        <div class="row">

            <div class="col-12">
                @include('admin.config.includes.menu-config')
            </div>

        </div>

    </div>


    <div class="card-body">

        @if (($config->module_contact ?? null) == 'inactive')
            <div class="alert alert-danger">
                {{ __('Warning. Contact module is not active. You can manege content, but module is not available on the website') }}.
                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('admin.config', ['module' => 'general']) }}">{{ __('Manage modules') }}</a>
                @endif
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success py-2">
                @if ($message == 'updated')
                    <div class="fw-bold">{{ __('Updated') }}</div>
                    <i class="bi bi-exclamation-circle"></i>
                    {{ __("Note: if you don't see any changes on website, you can try to reload the website using CTRL+F5 or clear browser cache.") }}
                @endif
            </div>
        @endif

        <form method="post">
            @csrf

            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="card bg-light p-3 mb-3">
                        <div class="fw-bold fs-5 mb-2">{{ __('Contact form settings') }}</div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="contact_form_disabled" value="">
                                    <input class="form-check-input" type="checkbox" id="customSwitch" name="contact_form_disabled" @if ($config->contact_form_disabled ?? null) checked @endif>
                                    <label class="form-check-label" for="customSwitch">{{ __('Disable contact form') }}</label>
                                </div>
                                <div class="text-muted small">{{ __('If checked, contact form is not displayed on the contact page and visitors can not send messages.') }}</div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-3">
                            <div class="form-group">
                                <label>{{ __('Fields size') }}</label>
                                <select class="form-select" name="contact_form_fields_size">
                                    <option value="">{{ __('Normal') }}</option>
                                    <option value="sm" @if (($config->contact_form_fields_size ?? null) == 'sm') selected @endif>{{ __('Small') }}</option>
                                    <option value="lg" @if (($config->contact_form_fields_size ?? null) == 'lg') selected @endif>{{ __('Large') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group mb-0 mt-3">
                                @if (!($config->google_recaptcha_enabled ?? null) || !($config->google_recaptcha_site_key ?? null) || !($config->google_recaptcha_secret_key ?? null))
                                    <div class="text-danger fw-bold mb-1">
                                        <i class="bi bi-info-circle"></i> {{ __('Warning: you must set Google reCAPTCHA keys to Enable Google reCAPTCHA antispam.') }} <a
                                            href="{{ route('admin.config', ['module' => 'integration']) }}">{{ __('Go to Googpe maps API settings') }}</a>
                                    </div>
                                @endif

                                <div class="form-check form-switch">
                                    <input type="hidden" name="contact_form_recaptcha" value="">
                                    <input class="form-check-input" type="checkbox" id="SwitchreCAPTCHA" name="contact_form_recaptcha" @if (!($config->google_recaptcha_enabled ?? null) || !($config->google_recaptcha_site_key ?? null) || !($config->google_recaptcha_secret_key ?? null)) disabled @endif
                                        @if ($config->contact_form_recaptcha ?? null) checked @endif>
                                    <label class="form-check-label" for="SwitchreCAPTCHA">{{ __('Enable Google reCAPTCHA antispam') }} </label>
                                    <div class="form-text"><a href="{{ route('admin.config', ['module' => 'integration']) }}">{{ __('Manage reCAPTCHA keys') }}</a></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-light p-3 mb-3">
                        <div class="fw-bold fs-5 mb-2">{{ __('Google map') }}</div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="contact_map_enabled" value="">
                                    <input class="form-check-input" type="checkbox" id="contact_map_enabled" name="contact_map_enabled" @if ($config->contact_map_enabled ?? null) checked @endif>
                                    <label class="form-check-label" for="contact_map_enabled">{{ __('Enable Google map') }}</label>
                                </div>
                                <div class="text-muted small">{{ __('If checked, Google map is displayed at the top of the contact page (after navigation menu).') }}</div>
                            </div>
                        </div>

                        <script>
                            $('#contact_map_enabled').change(function() {
                                select = $(this).prop('checked');
                                if (select) {
                                    document.getElementById('hidden_div_show_map').style.display = 'block';
                                } else {
                                    document.getElementById('hidden_div_show_map').style.display = 'none';
                                }
                            })
                        </script>

                        <div id="hidden_div_show_map" style="display: @if ($config->contact_map_enabled ?? null) block @else none @endif" class="mt-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <labeL>{{ __('Map height (in pixels)') }}</labeL>
                                        <div class="input-group">
                                            <input type="number" step="10" class="form-control" aria-describedby="width-addon" name="contact_map_height" value="{{ $config->contact_map_height ?? 400 }}">
                                            <span class="input-group-text" id="width-addon">{{ __('pixels') }}</span>
                                        </div>
                                        <div class="form-text">
                                            {{ __('Default: 400px') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <labeL>{{ __('Zoom') }}</labeL>
                                        <div class="input-group">
                                            <input type="number" step="1" class="form-control" name="contact_map_zoom" value="{{ $config->contact_map_zoom ?? 16 }}">
                                        </div>
                                        <div class="form-text">
                                            {{ __('Numeric value from 10 (minimum zoom) to 20 (maximum zoom). Default: 16') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-12">
                                <labeL>{{ __('Map address') }}</labeL>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="contact_map_address" value="{{ $config->contact_map_address ?? null }}">
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle"></i>
                                    {{ __('Input COMPLETE addres to show the exact map location. Include country (required), city (required), street (required), street number (required) and postal code (optional).') }}
                                    <br>
                                    {{ __('Example: Eduardo Primo Yúfera, 1, Quatre Carreres, 46013 Valencia, Valencia, Spania') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="col-md-6 col-12">
                    <div class="card bg-light p-3 mb-3">
                        <div class="fw-bold fs-5 mb-2">{{ __('Custom text') }}</div>

                        <div class="form-group mb-0">
                            <div class="form-check form-switch">
                                <input type='hidden' value='' name='contact_custom_text'>
                                <input class="form-check-input" type="checkbox" id="contact_custom_text" name="contact_custom_text" @if ($config->contact_custom_text ?? null) checked @endif>
                                <label class="form-check-label" for="contact_custom_text">{{ __('Add a custom text in the contact page') }}</label>
                            </div>
                        </div>

                        <script>
                            $('#contact_custom_text').change(function() {
                                select = $(this).prop('checked');
                                if (select) {
                                    document.getElementById('hidden_div_show_custom_text').style.display = 'block';
                                } else {
                                    document.getElementById('hidden_div_show_custom_text').style.display = 'none';
                                }
                            })
                        </script>

                        <div id="hidden_div_show_custom_text" style="display: @if ($config->contact_custom_text ?? null) block @else none @endif" class="mt-2">

                            @foreach ($contact_custom_text as $lang_contact_text)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>
                                                @if (count($languages) > 1)
                                                    {!! flag($lang_contact_text['lang']->code) !!}
                                                    @endif {{ __('Text content') }} @if (count($languages) > 1)
                                                        -
                                                        {{ $lang_contact_text['lang']->name }} @if ($lang_contact_text['lang']->is_default)
                                                            ({{ __('default language') }})
                                                        @endif
                                                    @endif
                                            </label>
                                            <textarea name="contact_custom_text_{{ $lang_contact_text['lang']->id }}" class="form-control trumbowyg">{{ $lang_contact_text['content'] ?? null }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <hr>
                            <div class="col-12 col-md-6 col-lg-6 col-xl-4">
                                <div class="form-group">
                                    <label>{{ __('Text location') }}</label>
                                    <select class="form-select" name="contact_custom_text_location">
                                        <option @if (($config->contact_custom_text_location ?? null) == 'top') selected @endif value="top">{{ __('Top (above the contact form)') }}</option>
                                        <option @if (($config->contact_custom_text_location ?? null) == 'bottom') selected @endif value="bottom">{{ __('Bottom (below the contact form)') }}</option>
                                        <option @if (($config->contact_custom_text_location ?? null) == 'left') selected @endif value="left">{{ __('Left (left side of the contact form)') }}</option>
                                        <option @if (($config->contact_custom_text_location ?? null) == 'right') selected @endif value="right">{{ __('Right (right side of the contact form)') }}</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>


            <input type="hidden" name="module" value="contact">
            <button type="submit" class="btn btn-primary mt-3">{{ __('Update') }}</button>
        </form>

    </div>
    <!-- end card-body -->

</div>
