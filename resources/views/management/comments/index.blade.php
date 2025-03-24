@extends('layouts.master')

@section('content')

    <x-subheader 
        :title="$title" 
        :breadcrumbs="[
            ['url' => 'javascript:void;', 'text' => trans('general.menus.management')],
            ['url' => request()->url(), 'text' => $title],
        ]"  
    />

    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <x-table-head :permissions="['comments_create']" />

            <div class="m-portlet__body">
                <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <!--begin: Size and Search -->
                    <x-table-header />

                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Post</th>
                                <th>Content</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <a href="{{ route('management.posts.edit', $item->post_id) }}">{{ $item->post->title }}</a>
                                </td>
                                <td>{{ $item->content }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <x-status-badge status="{{ $item->status }}" />
                                </td>
                                <td nowrap>
                                    @if (auth()->user()->can('comments_reply') && !$item->is_replied)
                                    <a  title="{{ __('Reply') }}"  
                                        data-toggle="modal" 
                                        data-target="#reply-modal"
                                        data-id="{{ $item->id }}"
                                        data-content="{{ $item->content }}" 
                                        onclick="showDataFromModal(this)"
                                        class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill">
                                        <i class="la la-reply"></i>
                                    </a>
                                    @endif
                                    <x-action-button 
                                        :permissions="['comments_edit']" 
                                        icon="la la-edit" 
                                        title="{{ __('Edit') }}" 
                                        prefix="management.comments" 
                                        id="{{ $item->id }}" 
                                        method="GET" 
                                    />
                                    <x-action-button 
                                        :permissions="['comments_delete']" 
                                        icon="la la-trash" 
                                        title="{{ __('Delete') }}"
                                        prefix="management.comments" 
                                        id="{{ $item->id }}" 
                                        confirm="true" 
                                        method="DELETE" 
                                    />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!--begin: Pagination -->
                    {{ $items->appends(['search' => isset($search) ? $search : '', 'size' => isset($size) ? $size : 10])->links() }}
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>


    <!-- REPLY MODAL-->
    <x-form-modal id="reply-modal" title="{{ __('Reply comment') }}" action="{{ route('management.comments.reply') }}">
        <x-input 
            label="{{ __('ID') }}" 
            type="text" 
            id="reply-modal-id" 
            name="id"
            value="" 
            error=""
            readonly
        />
        <x-input 
            label="{{ trans('general.comments.form.content') }}" 
            type="text" 
            id="reply-modal-content" 
            name=""
            value="" 
            error=""
            readonly
        />
        <x-input 
            required="true"
            label="{{ trans('general.comments.form.reply_content') }}" 
            type="text" 
            id="content" 
            name="content"
            value="{{ old('content') }}" 
            error="{{ $errors->first('content') }}"
        />
    </x-form-modal>
    <!-- END REPLY MODAL-->

@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/demo/default/custom/crud/datatables/basic/scrollable.js') }}" type="text/javascript"></script>
@endsection

@section('css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection