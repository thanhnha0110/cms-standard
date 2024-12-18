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
            <x-form method="POST" action="{{ route('settings.general.post') }}" cancelUrl="{{ route('settings.general.get') }}">
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
                        <x-input 
                            label="{{ trans('general.settings.general.form.shop_name') }}" 
                            type="text" 
                            id="shop_name" 
                            name="shop_name"
                            value="{{ setting('shop_name', '') }}" 
                            error="{{ $errors->first('shop_name') }}" 
                        />
                        <x-input 
                            label="{{ trans('general.settings.general.form.company_name') }}" 
                            type="text" 
                            id="company_name" 
                            name="company_name"
                            value="{{ setting('company_name', '') }}" 
                            error="{{ $errors->first('company_name') }}" 
                        />

                        <div class="form-group m-form__group row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <x-input 
                                    label="{{ trans('general.settings.general.form.company_phone') }}" 
                                    type="text" 
                                    id="company_phone" 
                                    name="company_phone"
                                    value="{{ setting('company_phone', '') }}" 
                                    error="{{ $errors->first('company_phone') }}" 
                                />
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <x-input 
                                    label="{{ trans('general.settings.general.form.company_email') }}" 
                                    type="text" 
                                    id="company_email" 
                                    name="company_email"
                                    value="{{ setting('company_email', '') }}" 
                                    error="{{ $errors->first('company_email') }}" 
                                />
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <x-input 
                                    label="{{ trans('general.settings.general.form.company_tax') }}" 
                                    type="text" 
                                    id="company_tax" 
                                    name="company_tax"
                                    value="{{ setting('company_tax', '') }}" 
                                    error="{{ $errors->first('company_tax') }}" 
                                />
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <x-input 
                                    label="{{ trans('general.settings.general.form.company_fax') }}" 
                                    type="text" 
                                    id="company_fax" 
                                    name="company_fax"
                                    value="{{ setting('company_fax', '') }}" 
                                    error="{{ $errors->first('company_fax') }}" 
                                />
                            </div>
                        </div>

                        <x-input 
                            label="{{ trans('general.settings.general.form.company_address') }}" 
                            type="text" 
                            id="company_address" 
                            name="company_address"
                            value="{{ setting('company_address', '') }}" 
                            error="{{ $errors->first('company_address') }}" 
                        />

                        <div class="form-group m-form__group row">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <x-select 
                                    label="{{ trans('general.settings.general.form.company_country') }}"
                                    id="company_country" 
                                    name="company_country" 
                                    value="{{ setting('company_country', 'UTC') }}"
                                    :options="get_countries()"
                                    error="{{ $errors->first('company_country') }}"
                                />
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <x-input 
                                    label="{{ trans('general.settings.general.form.company_state') }}" 
                                    type="text" 
                                    id="company_state" 
                                    name="company_state"
                                    value="{{ setting('company_state', '') }}" 
                                    error="{{ $errors->first('company_state') }}" 
                                />
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <x-input 
                                    label="{{ trans('general.settings.general.form.company_city') }}" 
                                    type="text" 
                                    id="company_city" 
                                    name="company_city"
                                    value="{{ setting('company_city', '') }}" 
                                    error="{{ $errors->first('company_city') }}" 
                                />
                            </div>
                        </div>
                        <x-select 
                            label="{{ trans('general.settings.general.form.timezone') }}"
                            id="timezone" 
                            name="timezone" 
                            value="{{ setting('timezone', 'UTC') }}"
                            :options="get_timezones()"
                            error="{{ $errors->first('timezone') }}"
                        />
                        <x-select 
                            label="{{ trans('general.settings.general.form.site_language') }}"
                            id="site_language" 
                            name="site_language" 
                            value="{{ setting('site_language', 'en') }}"
                            :options="App\Enums\SiteLanguageEnum::toArray()"
                            error="{{ $errors->first('site_language') }}"
                        />
                        
                    </div>
                    <div class="tab-pane" id="admin_appearance" role="tabpanel">
                        <x-input 
                            label="{{ trans('general.settings.general.form.admin_title') }}" 
                            type="text" 
                            id="admin_title" 
                            name="admin_title"
                            value="{{ setting('admin_title', '') }}" 
                            error="{{ $errors->first('admin_title') }}" 
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