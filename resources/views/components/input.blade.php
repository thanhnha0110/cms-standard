<div class="form-group m-form__group @if($error) has-danger @endif">
    @if($label)
    <label class="form-control-label" for="{{ $id }}">{{ $label }} @if($required)<span class="label-required">*</span> @endif</label>
    @endif
    <input type="{{ $type }}" class="form-control m-input" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" {{ $attributes }}>
    
    @if($error)
    <div class="form-control-feedback">{{ $error }}</div>
    @endif
</div>
