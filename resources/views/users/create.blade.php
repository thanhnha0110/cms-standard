@extends('layouts.master')

@section('content')

    <x-subheader 
        :title="$title" 
        :breadcrumbs="[
            ['url' => 'javascript:void;', 'text' => trans('general.menus.platform_administration')],
            ['url' => route('users.index'), 'text' => $title],
            ['url' => 'javascript:void;', 'text' => __('Create')],
        ]"  
    />

    <div class="m-content">
        <div class="row ">
            <div class="col-lg-6">

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
                    <x-form method="POST" action="{{ route('users.store') }}" cancelUrl="{{ route('users.index') }}">
                        <x-input 
                            required="true"
                            label="{{ trans('general.users.form.first_name') }}" 
                            type="text" 
                            id="first_name" 
                            name="first_name"
                            value="{{ old('first_name') }}" 
                            error="{{ $errors->first('first_name') }}" 
                        />
                        <x-input 
                            required="true"
                            label="{{ trans('general.users.form.last_name') }}" 
                            type="text" 
                            id="last_name" 
                            name="last_name" 
                            value="{{ old('last_name') }}" 
                            error="{{ $errors->first('last_name') }}" 
                        />
                        <x-input 
                            required="true"
                            label="{{ trans('general.users.form.email') }}" 
                            type="text" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            error="{{ $errors->first('email') }}" 
                        />
                        <x-select 
                            required="true"
                            label="{{ trans('general.users.form.role') }}"
                            id="role_id" 
                            name="role_id" 
                            value="{{ old('role_id') }}"
                            :options="[1 => 'Admin', 2 => 'Manager', 3 => 'Staff', 4 => 'Employee']"
                            error="{{ $errors->first('role_id') }}"
                        />
                        <x-select 
                            required="true"
                            label="{{ trans('general.users.form.status') }}"
                            id="status" 
                            name="status" 
                            value="{{ old('status') }}"
                            :options="App\Enums\UserStatusEnum::toArray()"
                            error="{{ $errors->first('role_id') }}"
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