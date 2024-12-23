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
            <x-table-head :permissions="['posts_create']" />

            <div class="m-portlet__body">
                <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <!--begin: Size and Search -->
                    <x-table-header />

                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Tags</th>
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
                                    <img class="tbl-featured_image" src="{{ $item->featured_image }}">
                                </td>
                                <td>
                                    <div class="tbl-title">{{ $item->title }}</div>
                                </td>
                                <td>{{ $item->category ? $item->category->name : '' }}</td>
                                <td>
                                    <x-tags :items="$item->tags" />
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <x-status status="{{ $item->status }}" />
                                </td>
                                <td nowrap>
                                    <x-action-button 
                                        :permissions="['posts_edit']" 
                                        icon="la la-edit" 
                                        title="{{ __('Edit') }}" 
                                        prefix="management.posts" 
                                        id="{{ $item->id }}" 
                                        method="GET" 
                                    />
                                    <x-action-button 
                                        :permissions="['posts_delete']" 
                                        icon="la la-trash" 
                                        title="{{ __('Delete') }}"
                                        prefix="management.posts" 
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

@endsection


@section('scripts')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/demo/default/custom/crud/datatables/basic/scrollable.js') }}" type="text/javascript"></script>
@endsection

@section('css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection