<div class="custom-control custom-switch">
    <label for="">Trạng thái</label>
    <label class="switch">
        <input type="checkbox" id="togBtn" name="{{ $name }}"
            {{isset($editData) ? '' : 'checked'}}
            {{ isset($editData) && $editData->$name == 1 ? 'checked' : '' }}>
        <div class="slider round">
            <span class="on">{{ $value1 }}</span>
            <span class="off">{{ $value0 }}</span>
        </div>
    </label>
</div>
