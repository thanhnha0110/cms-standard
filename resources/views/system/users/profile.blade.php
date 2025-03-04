@extends('layouts.master')

@section('content')

    <x-subheader 
        :title="$title" 
        :breadcrumbs="[
            ['url' => 'javascript:void;', 'text' => trans('general.menus.platform_administration')],
            ['url' => route('system.users.index'), 'text' => $title],
            ['url' => request()->url(), 'text' => $item->id],
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
                                    {{ __('Profile') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <x-form method="PUT" action="{{ route('system.users.update', $item->id) }}" cancelUrl="{{ route('system.users.index') }}">
                        <x-input 
                            required="true"
                            label="{{ trans('general.users.form.first_name') }}" 
                            type="text" 
                            id="first_name" 
                            name="first_name"
                            value="{{ $item->first_name }}" 
                            error="" 
                        />
                        <x-input 
                            required="true"
                            label="{{ trans('general.users.form.last_name') }}" 
                            type="text" 
                            id="last_name" 
                            name="last_name" 
                            value="{{ $item->last_name }}" 
                            error="" 
                        />
                        <x-input 
                            required="true"
                            label="{{ trans('general.users.form.email') }}" 
                            type="text" 
                            id="email" 
                            name="email" 
                            value="{{ $item->email }}" 
                            error="{{ $errors->first('email') }}"
                        />
                        <x-select 
                            required="true"
                            label="{{ trans('general.users.form.role') }}"
                            id="role_id" 
                            name="role_id" 
                            value="{{ $item->role_id }}"
                            :options="$roles"
                            error=""
                            disabled
                        />
                        <x-select 
                            required="true"
                            label="{{ trans('general.users.form.status') }}"
                            id="status" 
                            name="status" 
                            value="{{ $item->status }}"
                            :options="App\Enums\UserStatusEnum::toArray()"
                            error=""
                            disabled
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