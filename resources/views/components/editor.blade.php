<div class="form-group m-form__group @if($error) has-danger @endif">
    <label class="form-control-label" for="{{ $id }}">{{ $label }} @if($required)<span class="label-required">*</span> @endif</label>
    <textarea id="{{ $id }}" name="{{ $name }}">{!! $value !!}</textarea>

    @if($error)
    <div class="form-control-feedback">{{ $error }}</div>
    @endif
</div>


@push('scripts-editor')
<script>
    $('#{{ $id }}').summernote({
        height: 150,
        placeholder: 'Write your content here...',
        tabsize: 2
    });
</script>
@endpush
