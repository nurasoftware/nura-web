<?php
debug_backtrace() || die ("Direct access not permitted"); 
?>
<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="createLabel" aria-hidden="true" id="create-lang">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form method="post">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="createLabel">{{ __('Add language') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                     
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Language name') }}</label>
                                <input class="form-control" name="name" type="text" required />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Language code') }}</label>
                                <select name="code" class="selectpicker" data-live-search="true" title="{{ __('Select') }}" required>                                    
                                    @foreach($lang_codes_array as $key => $lang_code)
                                    @if($key == 'divider')<option disabled>-----------------</option>
                                    @else
                                    <option value="{{ $lang_code }}">{{ $key }} ({{ $lang_code }})</option>
                                    @endif
                                    @endforeach
                                </select>                             
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Locale') }}</label>
                                <select name="locale" class="selectpicker" data-live-search="true" title="{{ __('Select') }}" required>
                                    @foreach($locales_array as $key => $locale)
                                        <option value="{{ $key }}">{{ $locale }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                                         

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Timezone') }}</label>
                                <select name="timezone" class="selectpicker" data-live-search="true" title="{{ __('Select') }}" required>
                                    @foreach($timezones_array as $key => $timezone)
                                        <option value="{{ $key }}">{{ $timezone }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>   

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Status') }}</label>
                                <select name="status" class="form-select" aria-describedby="activeFrontendHelp">
                                    <option value="active">{{ __('Active') }}</option>
                                    <option value="inactive">{{ __('Inactive') }}</option>
                                    <option value="disabled">{{ __('Disabled') }}</option>
                                </select>
                                <div class="text-muted small">{{ __('If there are more tnah one active language, a language selector will be active in website') }}</div>
                            </div>
                        </div>         
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Text direction') }}</label>
                                <select name="dir" class="form-select" aria-describedby="activeFrontendHelp">
                                    <option value="ltr" selected>{{ __('LTR (Left to Right)') }}</option>
                                    <option value="rtl">{{ __('RTL (Right to Left)') }}</option>                                    
                                </select>
                            </div>
                        </div>      
                                 
                        <div class="col-12">
                            <div class="form-group">
                                <label>{{ __('Website label') }}</label>
                                <input class="form-control" name="site_label" type="text" required />
                                <div class="text-muted small">{{ __('A short website title (1-3 words)') }}</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="customSwitchDefault" name="is_default">
                                    <label class="form-check-label" for="customSwitchDefault">{{ __('Default language') }}</label>
                                </div>
                            </div>
                        </div>
                             

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Add language') }}</button>
                </div>

            </form>

        </div>
    </div>
</div>