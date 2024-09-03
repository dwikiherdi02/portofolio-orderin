@props(['forname', 'errors'])
<div class="form-error-message form-text text-xs text-danger font-weight-bold" for-name="{{ $forname ?? '' }}">
    @if (!empty($forname) && $errors->has($forname))
    {{ $errors->first($forname) }}
    @else
    {{ $slot }}
    @endif
</div>
