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
                            <a onclick="showImageInfo('{{ $item->name }}', '{{ $item->url }}', '{{ format_datetime($item->created_at) }}', '{{ $item->alt }}')">
                                <div class="m-image__item">
                                    <img src="{{ $item->url }}" alt="{{ $item->alt }}">
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="m-dropzone rv-media-thumbnail">
                            <div class="m-dropzone__msg dz-message needsclick">
                                <img src="{{ asset('assets/app/media/img/default.jpg') }}" >
                            </div>
                        </div>
                        <div class="rv-media-description">
                            <div class="rv-media-name">
                                <p for="rv-media-name">{{ __('Name') }}</p>
                                <span id="rv-media-name">_</span>
                            </div>
                            <div class="rv-media-name">
                                <p for="rv-media-url">{{ __('Full URL') }}</p>
                                <span id="rv-media-url">_</span>
                            </div>
                            <div class="rv-media-name">
                                <p for="rv-media-created">{{ __('Uploaded at') }}</p>
                                <span id="rv-media-created">_</span>
                            </div>
                            <div class="rv-media-name">
                                <p for="rv-media-alt">{{ __('Alt text') }}</p>
                                <span id="rv-media-alt">_</span>
                            </div>
                        </div>
                            
                    </div>
                </div>
                <div>Load more</div>

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


        // Review image
        function showImageInfo(name, url, created, alt) {
            const previewImg = document.querySelector('.m-dropzone__msg img');
            const nameSpan = document.querySelector('#rv-media-name');
            const urlSpan = document.querySelector('#rv-media-url');
            const createdSpan = document.querySelector('#rv-media-created');
            const altSpan = document.querySelector('#rv-media-alt');

            // Show review
            previewImg.setAttribute('src', url);
            nameSpan.textContent = name;
            urlSpan.textContent = url;
            createdSpan.textContent = created;
            altSpan.textContent = alt;
        }

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
        .rv-media-description {
            padding: 10px;
            position: relative;
        }
        .rv-media-description .rv-media-name {
            font-size: 13px;
            margin-bottom: 5px;
        }
        .rv-media-description .rv-media-name>p {
            font-weight: 600;
            margin: 0;
        }
    </style>
@endsection