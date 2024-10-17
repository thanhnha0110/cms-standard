<a href="{{ $getUrl() }}" 
    class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" 
    title="{{ $title }}" 
    @if($confirm && $method === 'DELETE') onclick="event.preventDefault(); confirmDelete('{{ $prefix }}', '{{ $id }}');" @endif
>
    <i class="{{ $icon }}"></i>
</a>


<script>
    function confirmDelete(prefix, id) {
        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                url: "{{ route($prefix . '.destroy', $id) }}",
                method: 'DELETE',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    toastr.success(response.data, 'Success')

                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.error.message, 'Error')
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            });
        }
    }
</script>