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
            <x-form method="POST" action="{{ route('settings.api.post') }}" cancelUrl="{{ route('settings.general.get') }}">
                <ul class="nav nav-tabs  m-tabs-line" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#general_information" role="tab" aria-selected="true">{{ trans('general.settings.general.form.information') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="general_information" role="tabpanel">
                        <x-input 
                            label="{{ trans('general.settings.api.form.url') }}" 
                            type="text" 
                            id="api_url" 
                            name="api_url"
                            value="{{ setting('api_url', '') }}" 
                            error="{{ $errors->first('api_url') }}" 
                        />
                        <x-input 
                            label="{{ trans('general.settings.api.form.access_key') }}" 
                            type="text" 
                            id="access_key" 
                            name="access_key"
                            value="{{ setting('access_key', '') }}" 
                            error="{{ $errors->first('access_key') }}" 
                        />
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