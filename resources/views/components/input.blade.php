<div class="form-group m-form__group @if($error) has-danger @endif">
    <label class="form-control-label" for="{{ $id }}">{{ $label }} @if($required)<span class="label-required">*</span> @endif</label>
    <input type="{{ $type }}" class="form-control m-input" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}">
    
    @if($error)
    <div class="form-control-feedback">{{ $error }}</div>
    @endif
</div>
