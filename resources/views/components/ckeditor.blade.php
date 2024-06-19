<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title">
                    {{ $labelText }}
                </h3>
            </div>
            <div class="card-body">
                <textarea id="{{ $name }}" name="{{ $name }}" class="ckeditor-cus">
                    {!! isset($editData) ? $editData->description : '' !!}
                </textarea>
            </div>

        </div>
    </div>
</div>
