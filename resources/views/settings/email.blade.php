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
            <x-form method="POST" action="{{ route('settings.email.post') }}" cancelUrl="{{ route('settings.email.get') }}">
                <ul class="nav nav-tabs  m-tabs-line" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#general_information" role="tab" aria-selected="true">{{ trans('general.settings.email.form.settings') }}</a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#templates" role="tab" aria-selected="false">{{ trans('general.settings.email.form.templates') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="general_information" role="tabpanel">
                        <x-select 
                            label="{{ trans('general.settings.email.form.mailer') }}"
                            id="mailer"
                            name="mailer" 
                            value="{{ setting('mailer', 'smtp') }}"
                            :options="App\Enums\MailerEnum::toArray()"
                            error="{{ $errors->first('mailer') }}"
                            onchange="handleMailerChange(this)"
                        />

                        <!-- SMTP settings -->
                        <div id="smtp-settings" class="mailer-settings" style="display: none;">
                            <x-input 
                                label="{{ trans('general.settings.email.form.smtp.port') }}" 
                                type="text" 
                                id="smtp_port" 
                                name="smtp_port"
                                value="{{ setting('smtp_port', '587') }}" 
                                error="{{ $errors->first('smtp_port') }}" 
                            />
                            <x-input 
                                label="{{ trans('general.settings.email.form.smtp.host') }}" 
                                type="text" 
                                id="smtp_host" 
                                name="smtp_host"
                                value="{{ setting('smtp_host', '') }}" 
                                error="{{ $errors->first('smtp_host') }}"
                            />
                            <x-input 
                                label="{{ trans('general.settings.email.form.smtp.username') }}" 
                                type="text" 
                                id="smtp_username" 
                                name="smtp_username"
                                value="{{ setting('smtp_username', '') }}" 
                                error="{{ $errors->first('smtp_username') }}"
                            />
                            <x-input 
                                label="{{ trans('general.settings.email.form.smtp.password') }}" 
                                type="password" 
                                id="smtp_password" 
                                name="smtp_password"
                                value="{{ setting('smtp_password', '') }}" 
                                error="{{ $errors->first('smtp_password') }}"
                            />
                            <x-input 
                                label="{{ trans('general.settings.email.form.smtp.encryption') }}" 
                                type="text" 
                                id="smtp_encryption" 
                                name="smtp_encryption"
                                value="{{ setting('smtp_encryption', 'tls') }}" 
                                error="{{ $errors->first('smtp_encryption') }}"
                            />
                        </div>

                        <!-- SES settings -->
                        <div id="ses-settings" class="mailer-settings" style="display: none;">
                            <x-input 
                                label="{{ trans('general.settings.email.form.ses.key') }}" 
                                type="text" 
                                id="ses_key" 
                                name="ses_key"
                                value="{{ setting('ses_key', '') }}" 
                                error="{{ $errors->first('ses_key') }}" 
                            />
                            <x-input 
                                label="{{ trans('general.settings.email.form.ses.secret') }}" 
                                type="text" 
                                id="ses_secret" 
                                name="ses_secret"
                                value="{{ setting('ses_secret', '') }}" 
                                error="{{ $errors->first('ses_secret') }}"
                            />
                            <x-input 
                                label="{{ trans('general.settings.email.form.ses.region') }}" 
                                type="text" 
                                id="ses_region" 
                                name="ses_region"
                                value="{{ setting('ses_region', '') }}" 
                                error="{{ $errors->first('ses_region') }}"
                            />
                        </div>

                        <x-input 
                            label="{{ trans('general.settings.email.form.sender_name') }}" 
                            type="text" 
                            id="sender_name" 
                            name="sender_name"
                            value="{{ setting('sender_name', '') }}" 
                            error="{{ $errors->first('sender_name') }}"
                        />
                        <x-input 
                            label="{{ trans('general.settings.email.form.sender_email') }}" 
                            type="text" 
                            id="sender_email" 
                            name="sender_email"
                            value="{{ setting('sender_email', '') }}" 
                            error="{{ $errors->first('sender_email') }}"
                        />

                        <x-button
                            label="{{ trans('general.settings.email.form.send_test_mail_btn') }}" 
                            type="button"
                            id="send-test-mail-btn"
                            class="btn-info"
                            onclick="handleSendTestMail()"
                        />
                    </div>
                    <div class="tab-pane" id="templates" role="tabpanel">
                        <x-input 
                            label="{{ trans('general.settings.general.form.admin_title') }}" 
                            type="text" 
                            id="admin_title" 
                            name="admin_title"
                            value="{{ setting('admin_title', '') }}" 
                            error="{{ $errors->first('admin_title') }}" 
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
    <script>
        function handleMailerChange(select) {
            const settingsDivs = document.querySelectorAll('.mailer-settings');

            settingsDivs.forEach(div => {
                div.style.display = 'none';
            });

            const selectedValue = select.value;
            const selectedDiv = document.getElementById(`${selectedValue}-settings`);
            if (selectedDiv) {
                selectedDiv.style.display = 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const mailerSelect = document.getElementById('mailer');
            handleMailerChange(mailerSelect);
        });
    </script>
@endsection

@section('css')
@endsection