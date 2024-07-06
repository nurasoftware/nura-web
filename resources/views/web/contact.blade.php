<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $site_text_dir }}">

<head>

    <title>{{ $configLang->contact_meta_title ?? 'Contact' }}</title>
    <meta name="description" content="{{ $configLang->contact_meta_description ?? 'Contact' }}">

    @include('web.global.head')

    @if ($config->contact_form_recaptcha ?? null)
        <script src="https://www.google.com/recaptcha/api.js"></script>
    @endif

    @if ($config->contact_map_enabled ?? null)
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    @endif
</head>

<body class="style_global">

    <!-- Start Main Content -->
    <div class="content">
        @include('web.global.navigation')

        @if ($config->contact_map_enabled ?? null)
            <iframe style="width: 100%" height="{{ $config->contact_map_height ?? 400 }}"
                src="https://maps.google.com/maps?height=400&amp;hl=en&amp;q={{ $config->contact_map_address }}&amp;ie=UTF8&amp;t=&amp;z={{ $config->contact_map_zoom }}&amp;iwloc=B&amp;output=embed"></iframe>
        @endif

        <div class="container-xxl mt-5 mb-5">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    @if ($message == 'sent')
                        {{ __('Message sent. Thank you.') }}
                    @endif
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    @if ($message == 'recaptcha_error')
                        {{ __('Google reCaptcha error. Please try again.') }}
                    @endif
                </div>
            @endif

            @if (($config->contact_custom_text ?? null) && ($config->contact_custom_text_location ?? null) == 'top')
                <div class="my-4">
                    {!! $configLang->contact_custom_text ?? null !!}
                </div>
            @endif

            <div class="row">

                @if (($config->contact_custom_text ?? null) && ($config->contact_custom_text_location ?? null) == 'left')
                    <div class="col-md-6 gx-5">
                        {!! $configLang->contact_custom_text ?? null !!}
                    </div>
                @endif

                <div class="@if ((($config->contact_custom_text ?? null) && ($config->contact_custom_text_location ?? null) == 'left') || ($config->contact_custom_text_location ?? null) == 'right') ) col-md-6 gx-5 @endif">
                    @if (!($config->contact_form_disabled ?? null))
                        <form method="post" class="contact-form" id="contactForm">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('Your name') }}</label>
                                    <input type="text" name="name" class="form-control @if ($config->contact_form_fields_size ?? null) form-control-{{ $config->contact_form_fields_size }} @endif" id="name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('Your email') }}</label>
                                    <input type="email" class="form-control @if ($config->contact_form_fields_size ?? null) form-control-{{ $config->contact_form_fields_size }} @endif" name="email" id="email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('Subject') }}</label>
                                <input type="text" class="form-control @if ($config->contact_form_fields_size ?? null) form-control-{{ $config->contact_form_fields_size }} @endif" name="subject" id="subject" required>
                            </div>
                            <div class="form-group">
                                <label for="name">{{ __('Message') }}</label>
                                <textarea class="form-control" name="message" rows="5" required></textarea>
                            </div>


                            @foreach ($custom_fields as $field)
                                <div class="col-md-{{ $field['col_md'] ?? 12 }}">
                                    <div class="form-group">
                                        <label class="block-form-label">{{ $field['label'] }}</label>

                                        @php
                                            $arrayTypes = explode(',', 'text,email,file,number,month,date,time,datetime-local,color');
                                        @endphp

                                        @if (in_array($field['type'], $arrayTypes))
                                            <input type="{{ $field['type'] }}" class="form-control @if ($config->contact_form_fields_size ?? null) form-control-{{ $config->contact_form_fields_size }} @endif"
                                                name="{{ $field['id'] }}" @if ($field['required']) required @endif @if ($field['type'] == 'color') style="width: 100px" @endif
                                                @if ($field['type'] == 'file') accept=".doc,.docx,.xml,.pdf,.txt,.zip,.gz,.rar,application/msword,audio/*,video/*,text/*,image/*" @endif>
                                        @elseif ($field['type'] == 'textarea')
                                            <textarea class="form-control" rows="4" name="{{ $field['id'] }}" @if ($field['required']) required @endif></textarea>
                                        @elseif ($field['type'] == 'select')
                                            @php
                                                $field_options_array = explode(PHP_EOL, $field['dropdowns']);
                                            @endphp

                                            <select class="form-select @if ($config->contact_form_fields_size ?? null) form-select-{{ $config->contact_form_fields_size }} @endif" name="{{ $field['id'] }}"
                                                @if ($field['required']) required @endif>
                                                <option value="">- {{ __('Select') }} -</option>
                                                @foreach ($field_options_array as $field_dropdown_name)
                                                    <option value="{{ $field_dropdown_name }}">{{ $field_dropdown_name }}</option>
                                                @endforeach
                                            </select>
                                        @elseif ($field['type'] == 'checkbox')
                                            @php
                                                $field_options_array = explode(PHP_EOL, $field['dropdowns']);
                                            @endphp

                                            @foreach ($field_options_array as $field_dropdown_name)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" value="{{ $field_dropdown_name }}" id="check_{{ $field['id'] }}_{{ $field_dropdown_name }}"
                                                        name="{{ $field['id'] }}[]" @if ($field['required']) required @endif>
                                                    <label class="form-check-label fw-normal" for="check_{{ $field['id'] }}_{{ $field_dropdown_name }}">
                                                        @php
                                                            if (strlen($field_dropdown_name) == 7 && substr($field_dropdown_name, 0, 1) == '#') {
                                                                echo '<i class="bi bi-square-fill fs-3" style="color: ' . $field_dropdown_name . '"></i>';
                                                            } else {
                                                                echo $field_dropdown_name;
                                                            }
                                                        @endphp
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif

                                        @if ($field['info'])
                                            <div class="form-text text-muted small">{!! $field['info'] !!}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <input type="hidden" name="submit_frm" value="1">

                            @if ($config->contact_form_recaptcha ?? null)
                                <button type="submit" class="btn btn-primary g-recaptcha" data-sitekey="{{ $config->google_recaptcha_site_key }}" data-callback='onSubmit'
                                    data-action='submit'>{{ __('Send message') }}</button>
                                <script>
                                    function onSubmit(token) {
                                        document.getElementById("contactForm").submit();
                                    }
                                </script>
                            @else
                                <button type="submit" class="btn btn-primary">{{ __('Send message') }}</button>
                            @endif

                        </form>
                    @endif
                </div>


                @if (($config->contact_custom_text ?? null) && ($config->contact_custom_text_location ?? null) == 'right')
                    <div class="col-md-6 gx-5">
                        {!! $configLang->contact_custom_text ?? null !!}
                    </div>
                @endif
            </div>


            @if (($config->contact_custom_text ?? null) && ($config->contact_custom_text_location ?? null) == 'bottom')
                <div class="mb-4">
                    {!! $configLang->contact_custom_text ?? null !!}
                </div>
            @endif

        </div>

    </div>
    <!-- End Main Content -->

    @include('web.global.footer')   

</body>

</html>
