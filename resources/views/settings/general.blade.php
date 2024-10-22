@extends('layouts.master')

@section('content')

    <x-subheader 
        :title="$title" 
        :breadcrumbs="[
            ['url' => 'javascript:void;', 'text' => trans('general.menus.settings')],
            ['url' => request()->url(), 'text' => $title],
        ]"  
    />

    <div class="m-content">

        <!--begin::Portlet-->
        <div class="m-portlet">

            <!--begin::Form-->
            <x-form method="POST" action="{{ route('system.users.store') }}" cancelUrl="{{ route('system.users.index') }}">
                <ul class="nav nav-tabs  m-tabs-line" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#general_information" role="tab" aria-selected="true">{{ trans('general.settings.general.form.information') }}</a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#admin_appearance" role="tab" aria-selected="false">{{ trans('general.settings.general.form.appearance') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="general_information" role="tabpanel">
                        <x-select 
                            label="{{ trans('general.settings.general.form.timezone') }}"
                            id="status" 
                            name="status" 
                            value="{{ old('status') }}"
                            :options="App\Enums\UserStatusEnum::toArray()"
                            error="{{ $errors->first('role_id') }}"
                        />
                        <x-select 
                            label="{{ trans('general.settings.general.form.site_language') }}"
                            id="status" 
                            name="status" 
                            value="{{ old('status') }}"
                            :options="App\Enums\UserStatusEnum::toArray()"
                            error="{{ $errors->first('role_id') }}"
                        />
                        
                    </div>
                    <div class="tab-pane" id="admin_appearance" role="tabpanel">
                        <x-input 
                            label="{{ trans('general.settings.general.form.admin_title') }}" 
                            type="text" 
                            id="first_name" 
                            name="first_name"
                            value="{{ old('first_name') }}" 
                            error="{{ $errors->first('first_name') }}" 
                        />
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-12 col-sm-12">{{ trans('general.settings.general.form.admin_logo') }}</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="m-dropzone dropzone dz-clickable" action="inc/api/dropzone/upload.php" id="m-dropzone-one">
                                    <div class="m-dropzone__msg dz-message needsclick">
                                        <h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
                                        <span class="m-dropzone__msg-desc">This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-12 col-sm-12">{{ trans('general.settings.general.form.admin_favicon') }}</label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="m-dropzone dropzone dz-clickable" action="inc/api/dropzone/upload.php" id="m-dropzone-one">
                                    <div class="m-dropzone__msg dz-message needsclick">
                                        <h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
                                        <span class="m-dropzone__msg-desc">This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-form>

            <!--end::Form-->
        </div>

        <!--end::Portlet-->
    </div>

@endsection


@section('scripts')
@endsection

@section('css')
@endsection