<div class="form-group m-form__group @if($error) has-danger @endif">
    <label class="form-control-label" for="{{ $id }}">{{ $label }} @if($required)<span class="label-required">*</span> @endif</label>
    <select class="form-control m-input" id="{{ $id }}" name="{{ $name }}" {{ $attributes }}>
        @foreach($options as $key => $option)
            <option value="{{ $key }}" @if($key == $value) selected @endif>{{ $option }}</option>
        @endforeach
    </select>

    @if($error)
    <div class="form-control-feedback">{{ $error }}</div>
    @endif
</div>