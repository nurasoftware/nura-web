<div class="fw-bold mb-3 fs-5">{{ __('Theme settings') }}</div>

@foreach ($theme_settings as $key => $item)

    @if (($item['type'] ?? null) == 'boolean')
        <div class="form-group mb-3">
            <div class="form-check form-switch">
                <input type='hidden' value='' name='{{ $key }}'>
                <input class="form-check-input" type="checkbox" id="{{ $key }}" name="{{ $key }}" @if ($this_theme_config->$key ?? null) checked @elseif (($item['default'] ?? null) === true) checked @endif>
                <label class="form-check-label" for="{{ $key }}">{{ $item['label'] ?? null }}</label>
            </div>
            @if ($item['description'] ?? null)
                <div class="form-text">{{ $item['description'] ?? null }}</div>
            @endif
        </div>
    @endif
@endforeach

