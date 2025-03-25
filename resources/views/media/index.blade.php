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
                        <div class="m-image__list" id="image-list">
                            @foreach ($items as $item)
                            <a onclick="showImageInfo('{{ $item->name }}', '{{ $item->url }}', '{{ format_datetime($item->created_at) }}', '{{ $item->alt }}')">
                                <div class="m-image__item" data-id="{{ $item->id }}">
                                    <img src="{{ get_full_path($item->url) }}" alt="{{ $item->alt }}" class="m-image__item" data-id="{{ $item->id }}">
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
                <div>
                    <button id="load-more" class="btn btn-default" data-page="2" onclick="loadMore(this)">{{ __('Load more') }}</button>
                </div>

                <!-- Menu click right -->
                <div id="context-menu" class="hidden">
                    <ul>
                        @can('media_edit')<li onclick="editImage()">{{ __('Edit') }}</li>@endcan
                        @can('media_delete')<li onclick="deleteImage()">{{ __('Delete') }}</li>@endcan
                    </ul>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

@endsection


@section('scripts')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    <script>
        // -------------------Upload image----------------------------
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


        // -------------------Review image----------------------------
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


        // -------------------Load more images------------------------
        function loadMore(btn) {
            const button = $(btn);
            const page = button.data('page');

            $.ajax({
                url: '{{ route('media.load-more') }}',
                type: 'GET',
                data: { page: page },
                beforeSend: function() {
                    button.text('Loading...');
                    button.prop('disabled', true);
                },
                success: function(response) {
                    // Append new images to the list
                    response.data.items.forEach(image => {
                        $('#image-list').append(`
                            <a onclick="showImageInfo('${image.name}', '${image.url}', '${image.created_at}', '${image.alt}')">
                                <div class="m-image__item" class="m-image__item" data-id="${image.id}">
                                    <img src="${image.url}" alt="${image.alt}" class="m-image__item" data-id="${image.id}">
                                </div>
                            </a>
                        `);
                    });

                    // Update button state
                    if (response.data.next_page) {
                        button.data('page', response.data.next_page);
                        button.text('Load More');
                        button.prop('disabled', false);
                    } else {
                        button.remove();
                    }
                },
                error: function() {
                    button.text('Load More');
                    button.prop('disabled', false);
                    alert('Failed to load more images.');
                }
            });
        }


        // -------------------Show menu click right-------------------
        let currentImageId = null;
        document.addEventListener('DOMContentLoaded', function () {
            const gallery = document.getElementById('image-list');
            const contextMenu = document.getElementById('context-menu');


            // listen event
            gallery.addEventListener('contextmenu', function (event) {
                event.preventDefault();

                // check click image
                if (event.target.classList.contains('m-image__item')) {
                    currentImageId = event.target.getAttribute('data-id');
                    showContextMenu(event, contextMenu);
                }
            });

            // Hide menu when click outside
            document.addEventListener('click', function () {
                hideContextMenu(contextMenu);
            });

            // reduce close menu when click
            contextMenu.addEventListener('click', function (event) {
                event.stopPropagation();
            });
        });

        // show menu in mouse position
        function showContextMenu(event, menu) {
            menu.style.display = 'block';
            menu.style.left = `${event.pageX}px`;
            menu.style.top = `${event.pageY}px`;

        }

        // hide menu
        function hideContextMenu(menu) {
            menu.style.display = 'none';
        }

        // -------------------Edit image------------------
        function editImage() {
            alert(`Edit image with ID: ${currentImageId}`);
            hideContextMenu(document.getElementById('context-menu'));
        }

        // -------------------Delete image------------------
        function deleteImage() {
            if (confirm('Are you sure you want to delete this item?')) {
                fetch(`/admin/media/${currentImageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    console.log(response)
                    if (response.ok) {
                        toastr.success(response.data, 'Success')
                        document.querySelector(`[data-id="${currentImageId}"]`).remove();

                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        toastr.error(response.statusText, 'Error')
                    }
                })
                .catch(error => {
                    toastr.error(error.message, 'Error')
                });
            }
            hideContextMenu(document.getElementById('context-menu'));
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

        .rv-media-description .rv-media-name span {
            display: block;
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }



        /* Format menu */
        #context-menu {
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            padding: 10px;
            border-radius: 5px;
        }

        #context-menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        #context-menu li {
            padding: 8px 12px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        #context-menu li:hover {
            background-color: #f0f0f0;
        }
    </style>
@endsection