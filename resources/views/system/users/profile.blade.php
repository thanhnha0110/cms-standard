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
            <div class="col-4">
                <div class="m-portlet m-portlet--full-height  ">
                    <div class="m-portlet__body">
                        <div class="m-card-profile">
                            <div class="m-card-profile__pic">
                                <div class="m-dropzone rv-media-thumbnail">
                                    <div class="m-dropzone__msg">
                                        @if ($item->avatar)
                                        <img src="{{ get_full_path($item->avatar) }}" class="rv-avatar" />
                                        @else
                                        <img src="{{ asset('assets/app/media/img/users/default.png') }}" class="rv-avatar" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="m-card-profile__details mt-2">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#gallery-modal" data-input="avatar">{{ __('Choose image') }}</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
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
                        <x-input
                            type="hidden" 
                            id="avatar" 
                            name="avatar"
                            value="{{ old('avatar') }}" 
                            error="{{ $errors->first('avatar') }}"
                            placeholder="Featured image URL"
                            readonly
                        />
                    </x-form>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->


            </div>
        </div>
    </div>

    <x-gallery-modal :images="get_media_files()" />

@endsection


@section('scripts')
@endsection

@section('css')
@endsection