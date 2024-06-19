<div class="form-item">
    <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $name }}"
        {{ isset($disabled) ? 'disabled' : '' }} value="{{ isset($editData) ? $editData->$name : old($name) }}"
        class="@error($name) is-invalid @enderror{{ isset($editData) ? '' : ' input-new' }}">
    <label for="{{ $name }}">
        {{-- @if (!isset($disabled)) --}}
            {{ $labelText }}
        {{-- @endif --}}
        @error($name)
            <span class="error text_error">{{ $message }}</span>
        @enderror
    </label>
</div>
