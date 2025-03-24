@extends('layouts.master')

@section('content')

    <x-subheader 
        :title="$title" 
        :breadcrumbs="[
            ['url' => 'javascript:void;', 'text' => trans('general.menus.management')],
            ['url' => route('management.comments.index'), 'text' => $title],
            ['url' => request()->url(), 'text' => $item->id],
        ]"  
    />

    <div class="m-content">
        <div class="row ">
            <div class="col-lg-12">

                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                    <i class="la la-gear"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    {{ __('Edit') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <x-form method="PUT" action="{{ route('management.comments.update', $item->id) }}" cancelUrl="{{ route('management.comments.index') }}">
                        <x-input 
                            required="true"
                            label="{{ trans('general.comments.form.content') }}" 
                            type="text" 
                            id="name" 
                            name="name"
                            value="{{ $item->content }}" 
                            error="" 
                        />
                    </x-form>

                    <!--end::Form-->
                </div>

                <!--end::Portlet-->


            </div>
        </div>
    </div>

@endsection


@section('scripts')
@endsection

@section('css')
@endsection