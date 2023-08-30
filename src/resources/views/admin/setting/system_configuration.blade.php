@extends('admin.layouts.master')
@section('content')

    @php
        $registration_settings = (object) json_decode(site_settings("user_authentication"));
    @endphp

    <div class="i-card-md">
        <div class="card-body">
            <ul class="list-group">
                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-3 justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ translate('Email Notification') }}</h6>
                        <p>
                            <small>{{ translate('When enabled, this module sends necessary emails to users. If disabled, no emails will be sent. Prior to disabling, ensure there are no pending emails.') }}</small>
                        </p>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('email_notifications') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='email_notifications'
                                data-status='{{ site_settings('email_notifications') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="email-notification">

                            <label class="form-check-label" for="email-notification"></label>
                        </div>
                    </div>
                </li>


                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('Database Notifications') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate('Enable this module for notifications on database events (e.g., New Ticket Generation, New Messages) to users, agents, and administrators.') }}</small>
                        </p>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('database_notifications') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='database_notifications'
                                data-status='{{ site_settings('database_notifications') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="database_notifications">
                            <label class="form-check-label" for="database_notifications"></label>
                        </div>
                    </div>
                </li>


                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('Cookie Activation') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("Enabling this module activates the Accept Cookie prompt, allowing personalized user tracking with small files on their computer") }}</small>
                        </p>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('cookie') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update" data-key='cookie'
                                data-status='{{ site_settings('cookie') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="cookie">
                            <label class="form-check-label" for="cookie"></label>
                        </div>
                    </div>
                </li>


                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('App Debug') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("Enabling this module activates system debugging mode, aiding in troubleshooting by providing detailed error messages to identify code issues.") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input {{ env('app_debug') ? 'checked' : '' }} type="checkbox"
                                class="form-check-input status-update" data-key='app_debug'
                                data-status='{{ env('app_debug') ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="app_debug">
                            <label class="form-check-label" for="app_debug"></label>
                        </div>
                    </div>
                </li>

                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('User Registration') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("Enabling the module activates the User Register Module, indicating their interdependency for proper functioning.") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ $registration_settings->registration == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='registration'
                                data-status='{{ $registration_settings->registration == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="user_register">
                            <label class="form-check-label" for="user_register"></label>
                        </div>
                    </div>
                </li>


                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">{{ translate('Social Auth') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("It allows users to sign in or register using their social media accounts") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{  site_settings('social_login') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='social_login'
                                data-status='{{ site_settings('social_login') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="social_login">
                            <label class="form-check-label" for="social_login"></label>
                        </div>
                    </div>
               </li>

                <li
                    class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                    <div>
                        <h6 class=" mb-0">{{ translate('Email Verfications') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("When enabled, this module prompts users to verify their email addresses during registration by clicking a link or entering a code sent to their email.") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('email_verification') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='email_verification'
                                data-status='{{ site_settings('email_verification') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}"
                                id="email_verification">
                            <label class="form-check-label" for="email_verification"></label>
                        </div>
                    </div>
                </li>


           

                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                    <div>
                        <h6 class=" mb-0">{{ translate('Article Review Feature') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("This feature allows users to provide reviews and feedback on  articles they have accessed, enhancing user engagement and content assessment.") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('link_review') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='link_review'
                                data-status='{{ site_settings('link_review') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="link_review">
                            <label class="form-check-label" for="link_review"></label>
                        </div>
                    </div>
                </li>

                
            
            


                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('View Count By Ip') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("Tracks the number of views from unique IP addresses, providing valuable insights into user engagement and traffic patterns on your website.") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('ip_base_view_count') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='ip_base_view_count'
                                data-status='{{ site_settings('ip_base_view_count') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="ip_base_view_count">
                            <label class="form-check-label" for="ip_base_view_count"></label>
                        </div>
                    </div>
                </li>


                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('Social Sharing') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("Enables users to easily share content from your website on various social media platforms, boosting visibility and user engagement.") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('social_sharing') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='social_sharing'
                                data-status='{{ site_settings('social_sharing') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="social_sharing">
                            <label class="form-check-label" for="social_sharing"></label>
                        </div>
                    </div>
                </li>


                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('Show Pages In Header') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("Enables a 'Pages' section inside the website header") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('show_pages_in_header') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='show_pages_in_header'
                                data-status='{{ site_settings('show_pages_in_header') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="show_pages_in_header">
                            <label class="form-check-label" for="show_pages_in_header"></label>
                        </div>
                    </div>
                </li>


                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('Expired Subscription Delete') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("By activating this feature, the system will seamlessly handle the removal of expired links and subscriptions. Additionally, you have the flexibility to configure the time duration, in days, after which the system will automatically delete expired data. You can conveniently manage this functionality within the designated 'App Settings' section. ") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('expired_data_delete') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='expired_data_delete'
                                data-status='{{ site_settings('expired_data_delete') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="expired_data_delete">
                            <label class="form-check-label" for="expired_data_delete"></label>
                        </div>
                    </div>
                </li>


                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                    <div>
                        <h6 class=" mb-0">{{ translate('Live Chat') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("This Module  Enable User & Admin Live Chat") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('live_chat') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='live_chat'
                                data-status='{{ site_settings('live_chat') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="live_chat">
                            <label class="form-check-label" for="live_chat"></label>
                        </div>
                    </div>
                </li>


                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                    <div>
                        <h6 class=" mb-0">{{ translate('Slack Notification') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("This Module  Enable Slack Notifications") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('slack_notifications') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='slack_notifications'
                                data-status='{{ site_settings('slack_notifications') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="slack_notifications">
                            <label class="form-check-label" for="slack_notifications"></label>
                        </div>
                    </div>

                </li>


                <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">

                    <div>
                        <h6 class=" mb-0">{{ translate('Browser Notification') }}</h6>
                        <p class="mb-0">
                            <small>{{ translate("This Module  Enable Browser Notifications") }}</small>
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input
                                {{ site_settings('browser_notifications') == App\Enums\StatusEnum::true->status() ? 'checked' : '' }}
                                type="checkbox" class="form-check-input status-update"
                                data-key='browser_notifications'
                                data-status='{{ site_settings('browser_notifications') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status() }}'
                                data-route="{{ route('admin.setting.update.status') }}" id="browser_notifications">
                            <label class="form-check-label" for="browser_notifications"></label>
                        </div>
                    </div>
                    
                </li>

            </ul>
        </div>
    </div>

@endsection

