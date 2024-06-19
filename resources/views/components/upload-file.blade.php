<div class="row mt-3">
    <div class="col-12 text-center">
        <input type="file" name="{{ $name }}" class="form-control" style="display: none;">
        <button type="button" class="btn btn-primary btn-sm" id="add_image">Chọn ảnh</button>
        <div class="mb-2 mt-3">
            <img src="{{ isset($editData) ? asset('storage') . '/' . $editData : '/common/image/user-default.jpg' }}"
                alt="" id="preview_image" class="img-fluid">

        </div>
        <button type="button" class="btn btn-info btn-sm" id= "edit_image"
            {{ isset($editData) ? '' : 'style=display:none' }}>Chọn ảnh khác</button>
    </div>
</div>
