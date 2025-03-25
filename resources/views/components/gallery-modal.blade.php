<div class="modal fade" id="gallery-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Media gallery') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-8">
                        <div class="m-image__list" id="image-list">
                            @foreach ($images as $item)
                            <a onclick="showImageInfo('{{ $item->name }}', '{{ get_full_path($item->url) }}', '{{ format_datetime($item->created_at) }}', '{{ $item->alt }}')">
                                <div class="m-image__item" data-id="{{ $item->id }}">
                                    <img src="{{ get_full_path($item->url) }}" alt="{{ $item->alt }}" class="m-image__item" data-id="{{ $item->id }}">
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="m-dropzone rv-media-thumbnail">
                            <div class="m-dropzone__msg dz-message needsclick rv-media-image">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="insertImage(this)" id="btn-insert">{{ __('Insert') }}</button>
            </div>
        </div>
    </div>
</div>

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

<script>
    // -------------------Review image----------------------------
    function showImageInfo(name, url, created, alt) {
        const previewImg = document.querySelector('.rv-media-image img');
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

        $('#btn-insert').val(url);
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
                        <a onclick="showImageInfo('${image.name}', '{{ get_full_path('${image.url}') }}', '${image.created_at}', '${image.alt}')">
                            <div class="m-image__item" class="m-image__item" data-id="${image.id}">
                                <img src="{{ get_full_path('${image.url}') }}" alt="${image.alt}" class="m-image__item" data-id="${image.id}">
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



    // -------------------Choose & insert image------------------------
    let targetInputName = null;
    document.querySelectorAll('[data-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function () {
            targetInputName = this.getAttribute('data-input');
            console.log('Click insert image for ' + targetInputName);
        });
    });


    function insertImage(elm) {
        let imageUrl = elm.value;
        if (targetInputName) {
            const targetInput = document.querySelector(`input[name="${targetInputName}"]`);
            const previewImg = document.querySelector(`.rv-${targetInputName}`);
            if (targetInput) {
                targetInput.value = imageUrl;
                previewImg.setAttribute('src', imageUrl);
            }
        }
    }
    // -------------------End: Choose & insert image------------------------

</script>