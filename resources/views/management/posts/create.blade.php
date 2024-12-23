@extends('layouts.master')

@section('content')

    <x-subheader 
        :title="$title" 
        :breadcrumbs="[
            ['url' => 'javascript:void;', 'text' => trans('general.menus.management')],
            ['url' => route('management.posts.index'), 'text' => $title],
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
                    <x-form method="POST" action="{{ route('management.posts.store') }}" cancelUrl="{{ route('management.posts.index') }}">
                        <x-input 
                            required="true"
                            label="{{ trans('general.posts.form.title') }}" 
                            type="text" 
                            id="title" 
                            name="title"
                            value="{{ old('title') }}" 
                            error="{{ $errors->first('title') }}"
                        />
                        <x-input 
                            required="true"
                            label="{{ trans('general.posts.form.description') }}" 
                            type="text" 
                            id="description" 
                            name="description"
                            value="{{ old('description') }}" 
                            error="{{ $errors->first('description') }}"
                        />
                        <x-editor 
                            required="true"
                            label="{{ trans('general.posts.form.content') }}"
                            id="content" 
                            name="content"
                            value="{{ old('content') }}" 
                            error="{{ $errors->first('content') }}" 
                        />
                        <x-select 
                            label="{{ trans('general.posts.form.category') }}"
                            id="category_id" 
                            name="category_id" 
                            value="{{ old('category_id') }}"
                            :options="get_categories()"
                            error="{{ $errors->first('category_id') }}"
                        />

                        <div class="form-group m-form__group row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <x-input 
                                    label="{{ trans('general.posts.form.tags') }}" 
                                    type="text" 
                                    id="tags" 
                                    name="tags"
                                    value="{{ old('tags') }}" 
                                    error="{{ $errors->first('tags') }}"
                                />
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <x-input 
                                    label="{{ trans('general.posts.form.focus_keywords') }}" 
                                    type="text" 
                                    id="tags_focus_keywords" 
                                    name="focus_keywords"
                                    value="{{ old('focus_keywords') }}" 
                                    error="{{ $errors->first('focus_keywords') }}"
                                />
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <x-select 
                                    required="true"
                                    label="{{ trans('general.posts.form.status') }}"
                                    id="status" 
                                    name="status" 
                                    value="{{ old('status') }}"
                                    :options="App\Enums\StatusEnum::toArray()"
                                    error="{{ $errors->first('status') }}"
                                    onchange="showDivFromId(this, 'scheduled', 'published_at', 'datetime-local')"
                                />
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <x-input 
                                    label="{{ trans('general.posts.form.published_at') }}" 
                                    type="hidden" 
                                    id="published_at" 
                                    name="published_at"
                                    value="{{ old('published_at') }}" 
                                    error="{{ $errors->first('published_at') }}"
                                />
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-12 col-sm-12">{{ trans('general.posts.form.featured_image') }}</label>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="m-dropzone rv-media-thumbnail">
                                    <div class="m-dropzone__msg">
                                        <img src="{{ asset('assets/app/media/img/default.jpg') }}" class="rv-featured_image">
                                        <x-input
                                            type="text" 
                                            id="featured_image" 
                                            name="featured_image"
                                            value="{{ old('featured_image') }}" 
                                            error="{{ $errors->first('featured_image') }}"
                                            placeholder="Featured image URL"
                                            readonly
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#gallery-modal" data-input="featured_image">{{ __('Choose image') }}</button>
                            </div>
                        </div>
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
    @stack('scripts-editor'){{-- Use editor --}}
@endsection

@section('css')
@endsection