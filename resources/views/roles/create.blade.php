@extends('layouts.master')

@section('content')

    <x-subheader 
        :title="$title" 
        :breadcrumbs="[
            ['url' => 'javascript:void;', 'text' => trans('general.menus.platform_administration')],
            ['url' => route('roles.index'), 'text' => $title],
            ['url' => 'javascript:void;', 'text' => __('Create')],
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
                                    {{ __('Create') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <x-form method="POST" action="{{ route('roles.store') }}" cancelUrl="{{ route('roles.index') }}">
                        <x-input 
                            required="true"
                            label="{{ trans('general.roles_and_permissions.form.name') }}" 
                            type="text" 
                            id="name" 
                            name="name"
                            value="{{ old('name') }}" 
                            error="{{ $errors->first('name') }}" 
                        />


                        @foreach(config('role_and_permission') as $slug => $role)
                            <div class="m-form__group form-group row">
                                <label class="col-3 col-form-label"> {{ $role['title'] }} </label>
                                <div class="col-9">
                                    <div class="m-checkbox-inline">
                                        <label class="m-checkbox">
                                            <input type="checkbox"> Select All
                                            <span></span>
                                        </label>
                                        @foreach($role['permissions'] as $permission => $namePermission)
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="permissions[{{ $slug }}][]" value="{{ $permission }}"> {{ $namePermission }}
                                            <span></span>
                                        </label>
                                        @endforeach
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
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