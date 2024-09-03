@props(['size', 'name', 'isavatar', 'isactive'])
@php
$size = $size ?? 'md';
$name = $name ?? 'file';
$isavatar = isset($isavatar) && $isavatar == true ? 'image-thumbnail-avatar' : '';
$isactive = isset($isactive) && $isactive == true ? 'image-thumbnail-active' : '';
@endphp
<div class="d-flex flex-column flex-sm-row column-gap-3">
    <div class="py-2 py-sm-0 pr-sm-2 text-center text-sm-start">
        <div id="image-thumbnail-{{ $name }}"
            class="image-thumbnail image-thumbnail-{{ $size }} {{ $isavatar }} {{ $isactive }}">
            {{ $image }}
        </div>
    </div>

    <div class="align-self-center py-2 py-sm-0 pr-sm-2">
        <input type="hidden" name="isrm_{{ $name }}" id="isrm-{{ $name }}" value="0">
        <input type="file" name="{{ $name }}" id="upload-{{ $name }}" accept="image/*" hidden>
        <button type="button" id="btn-upload-{{ $name }}" class="btn btn-dark">{{ $uploadbtn }}</button>
        <button type="button" id="btn-remove-upload-{{ $name }}" class="btn btn-danger" style="display: none;">{{
            __('Remove') }}</button>
        <x-input-error :forname="$name"></x-input-error>
    </div>
</div>
