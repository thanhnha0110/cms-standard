<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--begin::Form-->
                <form method="POST" action="{{ $action }}" class="m-form" id="modal-form">
                    @csrf
                    {{ $slot }}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="submitModalForm()" id="btn-insert">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showDataFromModal(element) {
        let target = $(element).data('target');
        let id = $(element).data('id');
        let content = $(element).data('content');

        $(target+'-id').val(id);
        $(target+'-content').val(content);

        $(target).modal('show');
    }

    function submitModalForm() {
        $('#modal-form').submit();
    }
</script>
