<?php
debug_backtrace() || die ("Direct access not permitted"); 
?>
<div class="modal fade custom-modal" tabindex="-1" role="dialog" aria-labelledby="updateLabel{{ $lang->id }}" aria-hidden="true" id="update-lang-{{ $lang->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="{{ route('admin.languages.show', ['id' => $lang->id]) }}" method="post" id="update-lang-{{ $lang->id }}">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="updateLabel{{ $lang->id }}">{{ __('Update language') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                       
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Language name') }}</label>
                                <input class="form-control" name="name" type="text" maxlength="25" required value="{{ $lang->name }}" />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Language code') }}</label>
                                <select name="code" class="selectpicker" data-live-search="true" title="{{ __('Select') }}" required>                                    
                                    @foreach($lang_codes_array as $key => $lang_code)
                                    @if($key == 'divider')<option disabled>-----------------</option>
                                    @else
                                    <option @if($lang->code == $lang_code) selected @endif value="{{ $lang_code }}">{{ $key }} ({{ $lang_code }})</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Locale') }}</label>
                                <select name="locale" class="selectpicker" data-live-search="true" title="{{ __('Select') }}" required>
                                    <option @if (! $lang->locale) selected @endif value="">- {{ __('Select') }} -</option>
                                    @foreach($locales_array as $key => $locale)
                                        <option @if ($lang->locale == $key) selected @endif value="{{ $key }}">{{ $locale }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                    
                     
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Timezone') }}</label>
                                <select name="timezone" class="selectpicker" data-live-search="true" title="{{ __('Select') }}" required>
                                    <option @if (! $lang->timezone) selected @endif value="">- {{ __('Select') }} -</option>
                                    @foreach($timezones_array as $key => $timezone)
                                        <option @if ($lang->timezone == $key) selected @endif value="{{ $key }}">{{ $timezone }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>         
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Status') }}</label>
                                <select name="status" class="form-select" aria-describedby="activeFrontendHelp">
                                    <option @if ($lang->status == 'active') selected @endif value="active">{{ __('Active') }}</option>
                                    <option @if ($lang->status == 'inactive') selected @endif value="inactive">{{ __('Inactive') }}</option>
                                    <option @if ($lang->status == 'disabled') selected @endif value="disabled">{{ __('Disabled') }}</option>
                                </select>
                                <small id="activeFrontendHelp" class="form-text text-muted">{{ __('If there are more tnah one active language, a language selector will be active in website') }}</small>
                            </div>
                        </div>                           
                                                         
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Text direction') }}</label>
                                <select name="dir" class="form-select" aria-describedby="activeFrontendHelp">
                                    <option @if ($lang->dir == 'ltr') selected @endif value="ltr">{{ __('LTR (Left to Right)') }}</option>
                                    <option @if ($lang->dir == 'rtl') selected @endif value="rtl">{{ __('RTL (Right to Left)') }}</option>                                    
                                </select>
                            </div>
                        </div>      

                        <div class="col-12">
                            <div class="form-group">
                                <label>{{ __('Website label') }}</label>
                                <input class="form-control" name="site_label" type="text" required value="{{ $lang->site_label }}" />
                                <div class="text-muted small">{{ __('A short website title (1-3 words)') }}</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="customSwitchDefault_{{ $lang->id }}" name="is_default" @if($lang->is_default) checked @endif>
                                    <label class="form-check-label" for="customSwitchDefault_{{ $lang->id }}">{{ __('Default language') }}</label>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Update language') }}</button>
                </div>

            </form>

        </div>
    </div>
</div>