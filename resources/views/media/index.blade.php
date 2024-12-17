@extends('layouts.master')

@section('content')

    <x-subheader 
        :title="$title" 
        :breadcrumbs="[
            ['url' => 'javascript:void;', 'text' => trans('general.menus.media')],
            ['url' => request()->url(), 'text' => $title],
        ]"  
    />

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">

            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">&nbsp;</h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        @can('media_create')
                        <li class="m-portlet__nav-item">
                            <input type="file" id="imageUpload" name="image" accept="image/*" style="display: none;">

                            <a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air" onclick="document.getElementById('imageUpload').click()">
                                <span>
                                    <i class="la la-cloud-upload"></i>
                                    <span>{{ __('Upload') }}</span>
                                </span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </div>

            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-8">
                        <div class="m-image__list">
                            @foreach ($items as $item)
                            <div class="m-image__item">
                                <a href="#">
                                    <img src="{{ $item->url }}">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="m-dropzone dropzone dz-clickable" action="inc/api/dropzone/upload.php" id="m-dropzone-one">
                            <div class="m-dropzone__msg dz-message needsclick">
                                <h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
                                <span class="m-dropzone__msg-desc">This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.</span>
                            </div>
                        </div>
                            <x-input 
                                label="{{ trans('general.categories.form.name') }}" 
                                type="text" 
                                id="name" 
                                name="name"
                                value="{{ old('name') }}" 
                                error=""
                            />
                    </div>
                </div>
                <div>load more</div>

            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

@endsection


@section('scripts')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    {{-- upload image --}}
    <script>
        document.getElementById('imageUpload').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                // Display selected file name (optional)
                console.log('File selected:', file.name);
    
                // Optionally, you can preview the image
                const reader = new FileReader();
                reader.onload = function (e) {
                    console.log('Preview URL:', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });


        $('#imageUpload').on('change', function (event) {
            const formData = new FormData();
            formData.append('image', event.target.files[0]);

            $.ajax({
                url: '{{ route('media.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
        });
    </script>
@endsection

@section('css')
    <style>
        .m-image__list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .m-image__item {
            width: 85px;
            height: 85px;
            background-color: lightgray;
            text-align: center;
            line-height: 150px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
@endsection