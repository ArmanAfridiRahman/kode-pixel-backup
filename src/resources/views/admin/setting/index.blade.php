@extends('admin.layouts.master')

@section('content')

@php
    // user registration form settings
    $registrationFormSettings = json_decode(site_settings('user_registration_settings'),true);
	$registrationInputTypes = ['number','textarea','date','email','text','file'];

	//ticket input settings
	$ticketSettings = json_decode(site_settings('ticket_settings'),true);
	$inputTypes = ['number','textarea','date','email','text'];

	//file system settings
	$mimeTypes = json_decode(site_settings('mime_types'),true);
	$awsSettings = json_decode(site_settings('aws_s3'),true);
	$ftpSetttings = json_decode(site_settings('ftp'),true);
    $wasabiSettings = json_decode(site_settings('wasabi'),true);

    //auth settings
	$google_recaptcha = json_decode(site_settings('google_recaptcha'),true);
	$socail_login_settings = json_decode(site_settings('social_login_with'),true);
	$authSetting =  json_decode(site_settings('user_authentication'),true);
	$loginAttributes =  json_decode(site_settings('login_with'),true);


    //pusher settings

     $pusher =  json_decode(site_settings('pusher_settings'),true);


@endphp
    <div class="basic-setting">

        <div class="basic-setting-left">
            <div class="setting-tab sticky-side-div">

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="v-pills-basic-settings-tab" data-bs-toggle="tab" href="#v-pills-basic-settings" role="tab" aria-controls="v-pills-basic-settings" aria-selected="false" tabindex="-1">
                            <i class="las la-cog"></i> {{translate('Basic Settings')}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                            <a class="nav-link " id="v-pills-logging-tab" data-bs-toggle="tab" href="#v-pills-logging" role="tab" aria-controls="v-pills-logging" aria-selected="false" tabindex="-1">
                                <i class="las la-bug"></i> {{translate('Logging')}}
                            </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="v-pills-rateLimitting-tab" data-bs-toggle="tab" href="#v-pills-rateLimitting" role="tab" aria-controls="v-pills-rateLimitting" aria-selected="false" tabindex="-1">
                            <i class="las la-wave-square"></i> {{translate('Rate Limiting')}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="v-pills-basic-theme-setting-tab" data-bs-toggle="tab" href="#v-pills-basic-theme-settings" role="tab" aria-controls="v-pills-basic-theme-settings" aria-selected="false" tabindex="-1">
                            <i class="las la-palette"></i>{{translate('Theme Settings')}}
                        </a>
                    </li>


                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="v-pills-ticket-settings-tab" data-bs-toggle="tab" href="#v-pills-ticket-settings" role="tab" aria-controls="v-pills-ticket-settings" aria-selected="false" tabindex="-1">
                            <i class="las la-envelope"></i> {{translate("Ticket Settings")}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">

                        <a class="nav-link " id="v-pills-storage-tab" data-bs-toggle="tab" href="#v-pills-storage" role="tab" aria-controls="v-pills-storage" aria-selected="true">
                            <i class="las la-box"></i> {{translate('Storage Settings')}}
                        </a>
                    </li>



                    <li class="nav-item" role="presentation">

                        <a class="nav-link " id="v-pills-slack-tab" data-bs-toggle="tab" href="#v-pills-slack" role="tab" aria-controls="v-pills-slack" aria-selected="true">
                            <i class="lab la-slack"></i> {{translate('Slack Settings')}}
                        </a>
                    </li>


                    <li class="nav-item" role="presentation">

                        <a class="nav-link " id="v-pills-pusher-tab" data-bs-toggle="tab" href="#v-pills-pusher" role="tab" aria-controls="v-pills-pusher" aria-selected="true">
                            <i class="lab la-pushed"></i> {{translate('Pusher Settings')}}
                        </a>
                    </li>




                    <li class="nav-item" role="presentation">

                        <a class="nav-link " id="v-pills-recap-tab" data-bs-toggle="tab" href="#v-pills-recap" role="tab" aria-controls="v-pills-recap" aria-selected="true">
                            <i class="las la-shield-alt"></i>	{{translate('Recaptcha Settings')}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="v-pills-social-login-tab" data-bs-toggle="tab" href="#v-pills-social-login" role="tab" aria-controls="v-pills-social-login" aria-selected="true">
                            <i class="las la-hashtag"></i> {{translate('Social Login Settings')}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="v-pills-registration-tab" data-bs-toggle="tab" href="#v-pills-registration" role="tab" aria-controls="v-pills-registration" aria-selected="true">
                            <i class="las la-registered"></i> {{translate('Registration Settings')}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="v-pills-login-tab" data-bs-toggle="tab" href="#v-pills-login" role="tab" aria-controls="v-pills-login" aria-selected="true">
                            <i class="las la-sign-in-alt"></i> {{translate('Login Settings')}}
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">

                        <a class="nav-link" id="v-pills-logo-tab" data-bs-toggle="tab" href="#v-pills-logo" role="tab" aria-controls="v-pills-logo" aria-selected="false" tabindex="-1">
                            <i class="las la-image"></i> {{translate('Logo Settings')}}
                        </a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="basic-setting-right">
            <div id="myTabContent2" class="tab-content">
                <div class="tab-pane fade active show" id="v-pills-basic-settings" role="tabpanel" aria-labelledby="v-pills-basic-settings-tab">
                    <form id="settingsForm" class=""  enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Basic Information')}}
                                </h4>

                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#cronjob"  class="i-btn btn--md btn--primary"> <i class="las la-key me-2"></i>
                                    {{translate("Setup Cron Jobs")}}
                                </a>
                            </div>



                            <div class="card-body">
                                <div class="form-group form-check form-check-success mb-3 ">
                                    <input {{ site_settings('same_site_name') == App\Enums\StatusEnum::true->status() ? 'checked' :"" }} type="checkbox" class="form-check-input status-update"
                                    data-key ='same_site_name'
                                    data-status ='{{ site_settings('same_site_name') ==  App\Enums\StatusEnum::true->status() ?  App\Enums\StatusEnum::false->status() : App\Enums\StatusEnum::true->status()}}'
                                    data-route="{{ route('admin.setting.update.status') }}" class="form-check-input" type="checkbox" id="sameSiteName" >
                                    <label class="form-check-label mb-0" for="sameSiteName">
                                        {{translate("Use Same Site Name")}}
                                    </label>
                                </div>

                                <div class="row">
                                    <div class="col-lg-{{site_settings('same_site_name') == App\Enums\StatusEnum::true->status() ? 12 : 6}} site-name">
                                        <div class="form-inner">
                                            <label for="site_name" class="form-label">
                                                {{translate('Site Name')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[site_name]" id="site_name" class="" value="{{site_settings('site_name')}}" required placeholder="{{translate("Name")}}">
                                        </div>
                                    </div>

                                    <div class="{{site_settings('same_site_name') == App\Enums\StatusEnum::true->status() ? 'd-none' : ""}}  col-lg-6 user-site-name form-inner">
                                        <label for="site_name">
                                            {{translate('User Site Name')}} <small class="text-danger" >*</small>
                                        </label>
                                        <input type="text" name="site_settings[user_site_name]" id="user_site_name" class="" value="{{site_settings('user_site_name')}}" required placeholder="{{translate("User Site Name")}}">
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="phone">
                                                {{translate('Phone')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[phone]" id="phone" class="" value="{{site_settings('phone')}}" required placeholder="{{translate("Phone")}}">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="email">
                                                {{translate('Email')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[email]" id="email" class="" value="{{site_settings('email')}}"  placeholder="email">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-inner">
                                            <label for="address">
                                                {{translate('Address')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[address]" id="address" class="" value="{{site_settings('address')}}"  placeholder="{{translate("address")}}">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-inner">
                                            <label for="twiter_username">
                                                {{translate('Twitter Username')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[twiter_username]" id="twiter_username" class="" value="{{site_settings('twiter_username')}}"  placeholder="{{translate("Twitter Username")}}">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="time_zone" class="form-label">
                                                {{translate('Time Zone')}} <small class="text-danger" >*</small>
                                            </label>

                                            <select  name="site_settings[time_zone]" id="time_zone" class=" select2 " id="time_zone">
                                                @foreach($timeZones as $timeZone)
                                                    <option value="'{{@$timeZone}}'" @if(config('app.timezone') == $timeZone) selected @endif>{{$timeZone}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="country" class="form-label">
                                                {{translate('Country')}} <small class="text-danger" >*</small>
                                            </label>
                                            <select  name="site_settings[country]" id="country" class=" select2 ">
                                                @foreach($countries as $country)
                                                    <option {{site_settings("country") == $country['name'] ? "selected" :""}} value="{{$country['name']}}">{{$country['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="Currency" class="form-label">
                                                {{translate('Currency')}} <small class="text-danger" >*</small>
                                            </label>
                                            <select  name="site_settings[currency]" id="currency" class="select2 ">
                                                @foreach($countries as $country)
                                                    @if(isset($country['currency']) && isset($country['currency']['code']) &&  $country['currency']['code'] != "" )
                                                        <option {{site_settings('currency') ==  Arr::get($country['currency'],'code','USD') ? 'selected' :"" }} value="{{Arr::get($country['currency'],'code','USD')}}">
                                                        {{Arr::get($country['currency'],'code','USD')}}
                                                        </option>
                                                    @endif

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="Currency" class="form-label">
                                                {{translate('Currency Symbol')}} <small class="text-danger" >*</small>
                                            </label>

                                            <select  name="site_settings[currency_symbol]" id="currency_symbol" class=" select2 " >
                                                @foreach($countries as $country)
                                                    @if(isset($country['currency']) && isset($country['currency']['symbol']) &&  $country['currency']['symbol'] != "" )
                                                            <option {{site_settings('currency_symbol') ==  Arr::get($country['currency'],'symbol','$') ? 'selected' :"" }} value="{{Arr::get($country['currency'],'symbol','$')}}">
                                                            {{Arr::get($country['currency'],'symbol','$')}}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="copy_right_text" class="form-label">
                                                {{translate('Copy Right Text')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[copy_right_text]" id="copy_right_text" class="" value="{{site_settings('copy_right_text')}}"  placeholder="Copy Right Text">
                                        </div>
                                    </div>



                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="pagination_number" class="form-label">
                                                {{translate('Data Per Page')}} <small class="text-danger" >*</small>
                                            </label>
                                                <input type="number" min="0" name="site_settings[pagination_number]" id="pagination_number" class="" value="{{site_settings('pagination_number')}}" required placeholder="Pagination Number">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="vistors" class="form-label">
                                                {{translate('Web Visitors')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="number" min="0" name="site_settings[vistors]" id="vistors" class="" value="{{site_settings('vistors')}}" required placeholder="Pagination Number">
                                        </div>
                                    </div>


                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="cookie_text" class="form-label">
                                                {{translate('Cookie Text')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text"  name="site_settings[cookie_text]" id="cookie_text" class="" value="{{site_settings('cookie_text')}}" required placeholder="{{translate("Enter Cookie Text")}}">
                                        </div>
                                    </div>



                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="google_adsense_publisher_id" class="form-label">
                                                {{translate('Google Adsense Publisher Id')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text"  name="site_settings[google_adsense_publisher_id]" id="google_adsense_publisher_id" class="" value="{{site_settings('google_adsense_publisher_id')}}" required placeholder="{{translate("Enter Id")}}">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-inner">
                                            <label for="google_adsense_publisher_id">
                                                {{translate('Google Analytics Tracking Id')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text"  name="site_settings[google_analytics_tracking_id]" id="google_analytics_tracking_id" class="" value="{{site_settings('google_analytics_tracking_id')}}" required placeholder="{{translate("Enter Id")}}">
                                        </div>
                                    </div>

                                    @if( site_settings('expired_data_delete') == App\Enums\StatusEnum::true->status())
                                        <div class="col-xl-6">
                                            <div class="form-inner">
                                                <label for="expired_data_delete_after" class="form-label">
                                                    {{translate('Expired Subscription Delete After')}} <small class="text-danger" >* ({{translate('In Days')}})</small>
                                                </label>
                                                <input type="text" name="site_settings[expired_data_delete_after]" id="expired_data_delete_after" class="" value="{{site_settings('expired_data_delete_after')}}"  placeholder="Copy Right Text">
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="chunk_value" class="form-label">
                                                {{translate('Chunk Value')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="number" min="0" name="site_settings[chunk_value]" id="chunk_value" class="" value="{{site_settings('chunk_value')}}" required placeholder="Chunk Value">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="site_description" class="form-label">
                                                {{translate('Site Description')}} <small class="text-danger" >*</small>
                                            </label>
                                            <textarea name="site_settings[site_description]" id="site_description" cols="30" rows="10">{{site_settings('site_description')}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12 ">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- loggin tab content -->
                <div class="tab-pane fade" id="v-pills-logging" role="tabpanel" aria-labelledby="v-pills-logging-tab">
                    <form class=""  id="settingsForm"   enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header ">
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <h4 class="card-title">
                                        {{translate('Logging')}}
                                    </h4>
                                    <p>
                                        (
                                            {{Arr::get(config('language'),'loggin_note',"")}}
                                        )
                                    </p>
                                </div>


                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 ">
                                        <div class="form-inner">
                                            <label for="sentry_dns">
                                                {{translate('Sentry Dns')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[sentry_dns]" id="sentry_dns" class="   " value="{{site_settings('sentry_dns')}}" required placeholder="sentry_dns">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 ">
                                        <div class="module-note">
                                            <label for ="">
                                                {{translate('Information')}}
                                            </label>
                                            <p>
                                                <a href="https://sentry.io" target="_blank">{{translate("Sentry")}}
                                                </a>
                                                <span>
                                                    {{Arr::get(config('language'),'sentry_note',"")}}

                                                </span>
                                            </p>
                                        </div>

                                    </div>

                                    <div class="col-12 ">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- rate limiting tab content -->
                <div class="tab-pane fade" id="v-pills-rateLimitting" role="tabpanel" aria-labelledby="v-pills-rateLimitting-tab">
                    <form class=""  id="settingsForm"   enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Rate Limitting')}}
                                </h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="api_route_rate_limit" class="form-label">
                                                {{translate('Api Hit limit')}} <small class="text-danger" >*({{translate('Per Minute')}})</small>
                                            </label>
                                            <input type="number" name="site_settings[api_route_rate_limit]" id="api_route_rate_limit" class="   " value="{{site_settings('api_route_rate_limit')}}" required placeholder="api_route_rate_limit">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 ">
                                        <div class="form-inner">
                                            <label for="web_route_rate_limit" class="form-label">
                                                {{translate('Web Route limit')}} <small class="text-danger" >*({{translate('Per Minute')}})</small>
                                            </label>
                                            <input type="number" name="site_settings[web_route_rate_limit]" id="web_route_rate_limit" class=" " value="{{site_settings('web_route_rate_limit')}}" required placeholder="web_route_rate_limit">
                                        </div>
                                    </div>

                                    <div class="col-12 ">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- theme color tab content -->
                <div class="tab-pane fade" id="v-pills-basic-theme-settings" role="tabpanel"   aria-labelledby="v-pills-basic-theme-settings-tab">
                    <form  id="settingsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Frontend Theme/Color Settings')}}
                                </h4>
                                <button class="i-btn btn--sm danger reset-color">
                                    <i class="las la-sync"></i>
                                </button>

                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="primary_color">
                                                {{translate('Primary Color')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[primary_color]" id="primary_color" class="   colorpicker" value="{{site_settings('primary_color')}}" required placeholder="primary_color">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="secondary_color">
                                                {{translate('Secondary Color')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[secondary_color]" id="secondary_color" class="   colorpicker" value="{{site_settings('secondary_color')}}" required placeholder="secondary_color">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="text_primary_color">
                                                {{translate('Text Primary Color')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[text_primary]" id="text_primary" class="colorpicker" value="{{site_settings('text_primary')}}" required placeholder="text_primary_color">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="text_secondary_color">
                                                {{translate('Text Secondary Color')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[text_secondary]" id="text_secondary" class="   colorpicker" value="{{site_settings('text_secondary')}}" required placeholder="primary_color">
                                        </div>
                                    </div>

                                    <div class="col-12 ">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- ticket settings tab content -->
                <div class="tab-pane fade" id="v-pills-ticket-settings" role="tabpanel" aria-labelledby="v-pills-ticket-settings-tab">
                    <form data-route="{{route('admin.setting.ticket.store')}}"  id="settingsForm"  method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Ticket Settings')}}
                                </h4>

                                <div class="action">
                                    <button id="add-ticket-option" class="i-btn btn--sm success">
                                        <i class="las la-plus me-1"></i>   {{translate('Add More')}}
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <!-- Table Foot -->
                                <div class="table-container">
                                    <table class="align-middle">
                                        <thead class="table-light ">
                                            <tr>
                                                <th scope="col">
                                                    {{translate('Labels')}}
                                                </th>

                                                <th scope="col">
                                                    {{translate('Type')}}
                                                </th>
                                                <th scope="col">
                                                    {{translate('Mandatory/Required')}}
                                                </th>

                                                <th scope="col">
                                                    {{translate('Placeholder')}}
                                                </th>

                                                <th scope="col">
                                                    {{translate('Action')}}
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody id="ticketField">
                                            @foreach ($ticketSettings as $ticketInput)
                                             <tr>
                                                <td data-label="{{translate("Label")}}">
                                                    <div class="form-inner mb-0">
                                                        <input type="text" name="ticket_setting[{{$loop->index}}][labels]" class="" value="{{$ticketInput['labels']}}">
                                                    </div>
                                                </td>

                                                <td data-label="{{translate("Type")}}">
                                                    <div class="form-inner mb-0">

                                                        @if($ticketInput['default'] == App\Enums\StatusEnum::true->status())
                                                            <input disabled   type="text" name="ticket_setting[type]" class="" value="{{$ticketInput['type']}}">
                                                            <input hidden  type="text" name="ticket_setting[{{$loop->index}}][type]" class="" value="{{$ticketInput['type']}}">
                                                        @else
                                                        <select class="select2" name="ticket_setting[{{$loop->index}}][type]" id="">
                                                            @foreach($inputTypes as $type)
                                                                <option {{$ticketInput['type'] == $type ?'selected' :""}} value="{{$type}}">
                                                                    {{ucfirst($type)}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @endif

                                                    </div>
                                                </td>

                                                <td  data-label="{{translate("Required")}}" >
                                                    <div class="form-inner mb-0">
                                                        @if($ticketInput['default'] == App\Enums\StatusEnum::true->status() && $ticketInput['type'] != 'file' )
                                                            <input disabled  type="text" name="ticket_setting[required]" class="" value="{{$ticketInput['required'] == App\Enums\StatusEnum::true->status()? 'Yes' :"No"}}">
                                                            <input hidden  type="text" name="ticket_setting[{{$loop->index}}][required]" class="" value="{{$ticketInput['required']}}">
                                                        @else
                                                            <select class="form-select" name="ticket_setting[{{$loop->index}}][required]" id="">
                                                                <option {{$ticketInput['required'] == App\Enums\StatusEnum::true->status() ?'selected' :""}} value="{{App\Enums\StatusEnum::true->status()}}">
                                                                    {{translate('Yes')}}
                                                                </option>
                                                                <option {{$ticketInput['required'] == App\Enums\StatusEnum::false->status() ?'selected' :""}} value="{{App\Enums\StatusEnum::false->status()}}">
                                                                    {{translate('No')}}
                                                                </option>
                                                            </select>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td  data-label="{{translate("Placeholder")}}">
                                                    <div class="form-inner mb-0">
                                                        <input   type="text" name="ticket_setting[{{$loop->index}}][placeholder]" class="" value="{{$ticketInput['placeholder']}}">
                                                    </div>
                                                    <input   type="hidden" name="ticket_setting[{{$loop->index}}][default]" class="" value="{{$ticketInput['default']}}">
                                                    <input   type="hidden" name="ticket_setting[{{$loop->index}}][multiple]" class="" value="{{$ticketInput['multiple']}}">
                                                    <input   type="hidden" name="ticket_setting[{{$loop->index}}][name]" class="" value="{{$ticketInput['name']}}">

                                                </td>

                                                <td data-label="{{translate("Option")}}">
                                                    @if($ticketInput['default'] == App\Enums\StatusEnum::true->status())
                                                        {{translate('N/A')}}
                                                        @else
                                                        <div>
                                                            <a href="javascript:void(0);" class="pointer icon-btn danger delete-option">
                                                                <i class="las la-trash-alt"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>

                                <div class="mt-20">
                                    <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                        {{translate("Submit")}}
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <!-- storage settings tab content -->
                <div class="tab-pane fade" id="v-pills-storage" role="tabpanel" aria-labelledby="v-pills-storage-tab">
                    <div class="i-card-md">
                        <div class="card--header">
                            <h4 class="card-title">
                                {{translate('Storage Settings')}}
                            </h4>
                        </div>

                        <div class="card-body">
                            <!-- Nav tabs -->
                            <div class="nav nav-tabs style-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#local" role="tab" aria-selected="true">
                                        {{translate('local')}}
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#aws-s3" role="tab" aria-selected="false" tabindex="-1">
                                        {{translate ('Aws S3')}}
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#ftp" role="tab" aria-selected="false" tabindex="-1">
                                        {{translate ('Ftp')}}
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#wasabi" role="tab" aria-selected="false" tabindex="-1">
                                        {{translate ('Wasabi')}}
                                    </a>
                                </li>

                            </div>
                            <!-- Tab panes -->
                            <div class="tab-content text-muted">
                                <!-- local file system -->
                                <div class="tab-pane active show" id="local" role="tabpanel">
                                    <form class="" id="settingsForm"  data-route="{{route('admin.setting.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex align-items-center gap-3 mb-20">
                                            <label for="">{{translate('Local Storage Settings')}}</label>

                                            <div class="form-check form-switch form-switch-md" dir="ltr">
                                                <input {{ site_settings('storage') == "local" ? 'checked' :"" }} type="checkbox" class="form-check-input"
                                                value ='local'
                                                name="site_settings[storage]"  id="storage">
                                                <label class="form-check-label mb-0" for="storage"></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-inner">
                                                    <label for="mime_types">
                                                        {{translate('Supported File Types')}}  <small class="text-danger" >*</small>
                                                    </label>
                                                    <select multiple class="select2-multi" name="site_settings[mime_types][]" id="mime_types">

                                                        @foreach(config('settings')['file_types'] as $file_type)

                                                            <option {{in_array($file_type,$mimeTypes) ? "selected" :"" }} value="{{$file_type}}">
                                                                {{$file_type}}
                                                            </option>

                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="form-inner">
                                                    <label for="max_file_upload">
                                                        {{translate('Maximum File Upload')}}  <small class="text-danger" >*
                                                            ({{translate('You Can Not Upload More Than That At a Time ')}})
                                                        </small>
                                                    </label>

                                                    <input type="number" min="1" max="10" required  value ="{{site_settings('max_file_upload')}}" name="site_settings[max_file_upload]" class="" type="text">
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="form-inner">
                                                    <label for="max_file_upload" class="form-label">
                                                        {{translate('Max File Upload size')}}  <small class="text-danger" >*
                                                            ({{translate('In Kilobyte')}})
                                                        </small>
                                                    </label>

                                                    <input type="number" min="1"  required  value ="{{site_settings('max_file_size')}}" name="site_settings[max_file_size]" class="" type="text">
                                                </div>
                                            </div>

                                            <div class="col-12 ">
                                                <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                                    {{translate("Submit")}}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- aws file system -->
                                <div class="tab-pane" id="aws-s3" role="tabpanel">
                                    <form class="" id="settingsForm"  data-route="{{route('admin.setting.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex align-items-center gap-3 mb-20">
                                            <label for="">{{translate('S3 Storage Settings')}}</label>
                                            <div class="form-check form-switch form-switch-md" dir="ltr">
                                                    <input {{ site_settings('storage') == "s3" ? 'checked' :"" }} type="checkbox" class="form-check-input"
                                                    value ='s3'
                                                    name="site_settings[storage]"  id="storage">
                                                    <label class="form-check-label mb-0" for="storage"></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            @foreach($awsSettings as $awsKey => $val)
                                                <div class="col-xl-6">
                                                    <div class="form-inner">
                                                        <label for="aws_s3">
                                                            {{
                                                                ucfirst(str_replace('_',' ',$awsKey))
                                                            }}  <small class="text-danger" >*</small>
                                                        </label>
                                                        <input required type="text" min="0" name="site_settings[aws_s3][{{$awsKey}}]" id="aws_s3" class="" value="{{$val}}" required placeholder="**********">
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-12">
                                                <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                                    {{translate("Submit")}}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- ftp file system -->
                                <div class="tab-pane" id="ftp" role="tabpanel">
                                    <form class="" id="settingsForm"  data-route="{{route('admin.setting.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex align-items-center gap-3 mb-20">
                                            <label for=""> {{translate('Ftp Settings')}}</label>
                                            <div class="form-check form-switch form-switch-md" dir="ltr">
                                                <input {{ site_settings('storage') == "ftp" ? 'checked' :"" }} type="checkbox" class="form-check-input"
                                                value ='ftp'
                                                name="site_settings[storage]"  id="storage">
                                                <label class="form-check-label mb-0" for="storage"></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            @foreach($ftpSetttings as $ftpKey => $val)
                                                <div class="col-xl-6">
                                                    <div class="form-inner">
                                                        <label for="ftp">
                                                            {{
                                                                ucfirst(str_replace('_',' ',$ftpKey))
                                                            }}  <small class="text-danger" >*</small>
                                                        </label>
                                                        <input required type="text" min="0" name="site_settings[ftp][{{$ftpKey}}]" id="ftp" class="" value="{{$val}}" required placeholder="**********">
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="col-12 ">
                                                <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                                    {{translate("Submit")}}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- wasabi file system -->
                                <div class="tab-pane" id="wasabi" role="tabpanel">
                                    <form class="" id="settingsForm"  data-route="{{route('admin.setting.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex align-items-center gap-3 mb-20">
                                            <label for=""> {{translate('Wasabi Settings')}}</label>
                                            <div class="form-check form-switch form-switch-md" dir="ltr">
                                                <input {{ site_settings('storage') == "wasabi" ? 'checked' :"" }} type="checkbox" class="form-check-input"
                                                       value ='wasabi'
                                                       name="site_settings[storage]"  id="storage">
                                                <label class="form-check-label mb-0" for="storage"></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            @foreach($wasabiSettings as $wasabiKey => $val)
                                                <div class="col-xl-6">
                                                    <div class="form-inner">
                                                        <label for="wasabi">
                                                            {{
                                                                ucfirst(str_replace('_',' ',$wasabiKey))
                                                            }}  <small class="text-danger" >*</small>
                                                        </label>
                                                        <input required type="text" min="0" name="site_settings[wasabi][{{$wasabiKey}}]" id="wasabi" class="" value="{{$val}}" required placeholder="**********">
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="col-12 ">
                                                <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                                    {{translate("Submit")}}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- slcak settings tab content -->
                <div class="tab-pane fade" id="v-pills-slack" role="tabpanel"   aria-labelledby="v-pills-slack-tab">
                    <form  id="settingsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Slack Configuration')}}
                                </h4>


                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="slack_channel">
                                                {{translate("Slack Channel")}} <small class="text-danger" >({{translate("optional")}})</small>
                                            </label>
                                            <input type="text" name="site_settings[slack_channel]" id="slack_channel"  value="{{site_settings('slack_channel')}}"  placeholder="{{translate("Slack Channel")}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="slack_web_hook_url">
                                                {{translate('Slack Web Hook Url')}} <small class="text-danger" >*</small>
                                            </label>
                                            <input type="text" name="site_settings[slack_web_hook_url]" id="slack_web_hook_url"  value="{{site_settings('slack_web_hook_url')}}" required placeholder="{{translate("Slack Web Hook Url")}}">
                                        </div>
                                    </div>




                                    <div class="col-12 ">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                 <!-- pusher settings tab content -->
                 <div class="tab-pane fade" id="v-pills-pusher" role="tabpanel"   aria-labelledby="v-pills-pusher-tab">
                    <form  id="settingsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Pusher Configuration')}}
                                </h4>

                            </div>

                            <div class="card-body">
                                <div class="row">

                                    @foreach($pusher as $key => $val)
                                        <div class="col-xl-6">
                                            <div class="form-inner">
                                                <label for="ftp">
                                                    {{
                                                        ucfirst(str_replace('_',' ',$key))
                                                    }}  <small class="text-danger" >*</small>
                                                </label>
                                                <input required type="text" min="0" name="site_settings[pusher_settings][{{$key}}]" id="pusher" class="" value="{{$val}}" required placeholder="**********">
                                            </div>
                                        </div>
                                    @endforeach


                                    <div class="col-12 ">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <!-- google recaptcha tab content -->
                <div class="tab-pane fade" id="v-pills-recap" role="tabpanel" aria-labelledby="v-pills-recap-tab">
                    <form id="settingsForm" data-route="{{route('admin.setting.plugin.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Recaptcha Settings')}}
                                </h4>
                            </div>

                            <div class="card-body">
                                <div class="d-flex gap-3">
                                    <div class="form-group form-check form-check-success">
                                        <input {{ site_settings('default_recaptcha') == App\Enums\StatusEnum::true->status() ? 'checked' :"" }} type="checkbox" class="form-check-input status-update"

                                        data-key ='default_recaptcha'
                                        data-status ='{{ site_settings('default_recaptcha') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() :App\Enums\StatusEnum::true->status()}}'
                                        data-route="{{ route('admin.setting.update.status') }}" class="form-check-input" type="checkbox" id="defaultCaptcha" >
                                        <label class="form-check-label mb-0" for="defaultCaptcha">
                                            {{translate("Use Default Captcha")}}
                                        </label>
                                    </div>

                                    <div class="form-group form-check form-check-success">
                                        <input {{ site_settings('captcha_with_registration') == App\Enums\StatusEnum::true->status() ? 'checked' :"" }} type="checkbox" class="form-check-input status-update"

                                        data-key ='captcha_with_registration'
                                        data-status ='{{ site_settings('captcha_with_registration') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() :App\Enums\StatusEnum::true->status()}}'
                                        data-route="{{ route('admin.setting.update.status') }}" class="form-check-input" type="checkbox" id="captcha_with_registration" >
                                        <label class="form-check-label mb-0" for="captcha_with_registration">
                                            {{translate("Captcha With Registration")}}
                                        </label>
                                    </div>

                                    <div class="form-group form-check form-check-success">
                                        <input {{ site_settings('captcha_with_login') == App\Enums\StatusEnum::true->status() ? 'checked' :"" }} type="checkbox" class="form-check-input status-update"

                                        data-key ='captcha_with_login'
                                        data-status ='{{ site_settings('captcha_with_login') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() :App\Enums\StatusEnum::true->status()}}'
                                        data-route="{{ route('admin.setting.update.status') }}" class="form-check-input" type="checkbox" id="captcha_with_login" >
                                        <label class="form-check-label mb-0" for="captcha_with_login">
                                            {{translate("Captcha With Login")}}
                                        </label>
                                    </div>

                                </div>

                                <div class="mt-20">
                                    <h6 class="mb-20">
                                        {{translate('Google Recaptcha (V3)')}}
                                    </h6>

                                    <div class="row google-captcha">
                                        @foreach($google_recaptcha as $key => $settings)
                                            <div class="col-xl-6">
                                                <div class="form-inner">
                                                    <label for="{{$key}}" class="form-label">
                                                        {{
                                                            Str::ucfirst(str_replace("_"," ",$key))
                                                        }}  <small class="text-danger" >*</small>
                                                    </label>
                                                    @if($key == 'status')
                                                    <select class="select2"  name='site_settings[google_recaptcha][{{$key}}]' class="select2"  id="{{$key}}" >
                                                        @foreach( App\Enums\StatusEnum::toArray() as $key => $val)
                                                            <option {{$settings ==  $val ? 'selected' :""}}  value="{{$val}}">
                                                                {{$key}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @else
                                                    <input id="{{$key}}" required class="" value="{{$settings}}" name='site_settings[google_recaptcha][{{$key}}]' placeholder="************" type="text">
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="col-12 ">
                                            <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                                {{translate("Submit")}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>

                <!-- socail login tab content -->
                <div class="tab-pane fade" id="v-pills-social-login" role="tabpanel" aria-labelledby="v-pills-social-login-tab">
                    <form class="" id="settingsForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Socail Login Setup')}}
                                </h4>
                            </div>
                            <div class="card-body">
                                @foreach($socail_login_settings  as $medium => $settings)
                                    <div class="mb-10">
                                        <h6>
                                            {{ ucWords(str_replace('_',' ',$medium))}}
                                        </h6>
                                        <div class="mt-30">
                                            @php
                                                $social_settings = ($settings);
                                            @endphp

                                            <div class="row">
                                                @foreach( $settings as $key => $val)
                                                    <div class="col-xl-6">
                                                        <div class="form-inner">
                                                            <label for="{{$key}}">
                                                                {{
                                                                    Str::ucfirst(str_replace("_"," ",$key))
                                                                }}  <small class="text-danger" >*</small>
                                                            </label>

                                                            @if($key == 'status')
                                                                <select class="form-select" name="site_settings[social_login_with][{{$medium}}][{{$key}}]" id="{{$key}}">
                                                                    <option {{$val == App\Enums\StatusEnum::true->status() ? "selected" :""}} value="{{App\Enums\StatusEnum::true->status()}}">
                                                                        {{translate('Active')}}
                                                                    </option>
                                                                    <option {{$val == App\Enums\StatusEnum::false->status() ? "selected" :""}} value="{{App\Enums\StatusEnum::false->status()}}">
                                                                        {{translate('Inactive')}}
                                                                    </option>
                                                                </select>

                                                            @else
                                                                <input required class="" value="{{$val}}" name='site_settings[social_login_with][{{$medium}}][{{$key}}]' placeholder="************" type="text">
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="col-xl-6">
                                                    <div class="form-inner">
                                                        <label for="callbackUrl">
                                                            {{translate('Callback Url')}}
                                                        </label>

                                                        <div class="input-group">
                                                            <input id="callbackUrl" readonly value="{{route('social.login.callback',str_replace("_oauth","",$medium))}}" type="text" class="form-control" >
                                                            <span class="input-group-text copy-text"  data-text ="{{route('social.login.callback',str_replace("_oauth","",$medium))}}"  class="input-group-text pointer copy-text"><i class="las la-copy"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div>
                                    <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                        {{translate("Submit")}}
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <!-- registration form settings tab content -->
                <div class="tab-pane fade" id="v-pills-registration" role="tabpanel" aria-labelledby="v-pills-registration-tab">
                    <form data-route="{{route('admin.setting.register.store')}}"  id="settingsForm"  method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Register Form Settings')}}
                                </h4>

                                <div class="action">
                                    <button id="add-option" class="i-btn btn--sm success">
                                        <i class="las la-plus me-1"></i>   {{translate('Add More')}}
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="d-flex gap-2">
                                    <div class="form-group form-check form-check-success mb-2 ">

                                        <input {{ site_settings('email_verification') == App\Enums\StatusEnum::true->status() ? 'checked' :"" }} type="checkbox" class="form-check-input email-verification status-update"

                                        data-key ='email_verification'
                                        data-status ='{{ site_settings('email_verification') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() :App\Enums\StatusEnum::true->status()}}'
                                        data-route="{{ route('admin.setting.update.status') }}" class="form-check-input" type="checkbox" id="email_verification" >
                                        <label class="form-check-label mb-0" for="email_verification">
                                            {{translate("Email Verification")}}
                                        </label>
                                    </div>
                                </div>

                                <!-- Table Foot -->
                                <div class="table-container">
                                    <table class="align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">
                                                    {{translate('Labels')}}
                                                </th>

                                                <th scope="col">
                                                    {{translate('Order')}}
                                                </th>

                                                <th scope="width">
                                                    {{translate('Width')}}
                                                </th>

                                                <th scope="width">
                                                    {{translate('Status')}}
                                                </th>

                                                <th scope="col">
                                                    {{translate('Type')}}
                                                </th>
                                                <th scope="col">
                                                    {{translate('Mandatory/Required')}}
                                                </th>

                                                <th scope="col">
                                                    {{translate('Placeholder')}}
                                                </th>

                                                <th scope="col">
                                                    {{translate('Options')}}
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody id="registerFeild">
                                            @foreach ($registrationFormSettings as $intput)
                                                <tr>
                                                    <td data-label="{{translate("Labels")}}">
                                                        <div class="form-inner mb-0">
                                                            <input type="text" name="registration[{{$loop->index}}][labels]" class="" value="{{$intput['labels']}}">
                                                        </div>
                                                    </td>

                                                    <td data-label="{{translate("Order")}}">
                                                        <div class="form-inner mb-0">
                                                            <input type="number" name="registration[{{$loop->index}}][order]" class="" value="{{$intput['order']}}">
                                                        </div>
                                                    </td>

                                                    <td data-label="{{translate("Width")}}">
                                                        <div class="form-inner mb-0">
                                                            <select class="select2"  name="registration[{{$loop->index}}][width]" id="">
                                                                <option {{$intput['width'] == '50' ?"selected" :""}} value="50">50%</option>
                                                                <option {{$intput['width'] == '100' ?"selected" :""}} value="100">100%</option>
                                                            </select>
                                                        </div>
                                                    </td>

                                                    <td data-label="{{translate("Status")}}">
                                                        <div class="form-inner mb-0">
                                                            @if($intput['name'] == 'user_name' || $intput['name'] == 'email' || $intput['name'] == 'phone' || $intput['name'] == 'name' )

                                                            <input hidden  type="text" name="registration[{{$loop->index}}][status]" class="" value="{{$intput['status']}}">
                                                            @endif



                                                            <select @if($intput['name'] == 'user_name' || $intput['name'] == 'email' || $intput['name'] == 'phone' || $intput['name'] == 'name' )
                                                            disabled
                                                            @endif

                                                            class="select2"  name="registration[{{$loop->index}}][status]" id="">
                                                                @foreach(App\Enums\StatusEnum::toArray() as $status=>$value)
                                                                    <option {{$intput['status'] == $value ? "selected" :"" }} value="{{$value}}">
                                                                        {{$status}}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </td>

                                                    <td data-label="{{translate('Type')}}">
                                                        <div class="form-inner mb-0">
                                                            @if($intput['default'] == App\Enums\StatusEnum::true->status())
                                                                <input disabled   type="text" name="registration[type]" class="" value="{{$intput['type']}}">
                                                                <input hidden  type="text" name="registration[{{$loop->index}}][type]" class="" value="{{$intput['type']}}">
                                                                @else

                                                                <select   class="select2" name="registration[{{$loop->index}}][type]" id="">
                                                                    @foreach($registrationInputTypes as $type)
                                                                        <option {{$intput['type'] == $type ?'selected' :""}} value="{{$type}}">
                                                                            {{ucfirst($type)}}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            @endif
                                                        </div>

                                                    </td>

                                                    <td data-label="{{translate('Required')}}">
                                                        <div class="form-inner mb-0">
                                                            @if($intput['default'] == App\Enums\StatusEnum::true->status() && $intput['name'] != 'country_code' )
                                                                <input disabled  type="text" name="registration[required]" class="" value="{{$intput['required'] == App\Enums\StatusEnum::true->status()? 'Yes' :"No"}}">
                                                                <input hidden  type="text" name="registration[{{$loop->index}}][required]" class="" value="{{$intput['required']}}">
                                                            @else
                                                                <select class="select2" name="registration[{{$loop->index}}][required]" id="">
                                                                    <option {{$intput['required'] == App\Enums\StatusEnum::true->status() ?'selected' :""}} value="{{App\Enums\StatusEnum::true->status()}}">
                                                                        {{translate('Yes')}}
                                                                    </option>
                                                                    <option {{$intput['required'] == App\Enums\StatusEnum::false->status() ?'selected' :""}} value="{{App\Enums\StatusEnum::false->status()}}">
                                                                        {{translate('No')}}
                                                                    </option>
                                                                </select>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    <td  data-label="{{translate('Placeholder')}}">
                                                        <div class="form-inner mb-0">
                                                            <input   type="text" name="registration[{{$loop->index}}][placeholder]" class="" value="{{$intput['placeholder']}}">
                                                            <input   type="hidden" name="registration[{{$loop->index}}][default]" class="" value="{{$intput['default']}}">
                                                            <input   type="hidden" name="registration[{{$loop->index}}][multiple]" class="" value="{{$intput['multiple']}}">
                                                            <input   type="hidden" name="registration[{{$loop->index}}][name]" class="" value="{{$intput['name']}}">
                                                        </div>

                                                    </td>

                                                    <td data-label="{{translate('Option')}}">
                                                        @if($intput['default'] == App\Enums\StatusEnum::true->status())
                                                                <small> {{translate('N/A')}}</small>
                                                            @else
                                                            <div class="table-action">
                                                                <a href="javascript:void(0);" class="pointer delete-item icon-btn danger">
                                                                    <i class="las la-trash-alt">
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-20">
                                    <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                        {{translate("Submit")}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Login settings tab content -->
                <div class="tab-pane fade" id="v-pills-login" role="tabpanel" aria-labelledby="v-pills-login-tab">
                    <form data-route="{{route('admin.setting.store')}}"  id="settingsForm"  method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('User Login Settings')}}
                                </h4>
                            </div>

                            <div class="card-body">
                                <div class="form-group form-check form-check-success mb-2 ">
                                    <input {{ site_settings('loggin_attempt_validation') == App\Enums\StatusEnum::true->status() ? 'checked' :"" }} type="checkbox" class="form-check-input status-update"

                                    data-key ='loggin_attempt_validation'
                                    data-status ='{{ site_settings('loggin_attempt_validation') == App\Enums\StatusEnum::true->status() ? App\Enums\StatusEnum::false->status() :App\Enums\StatusEnum::true->status()}}'
                                    data-route="{{ route('admin.setting.update.status') }}" class="form-check-input" type="checkbox" id="loggin_attempt_validation" >
                                    <label class="form-check-label mb-0" for="loggin_attempt_validation">
                                        {{translate("Max Login Attempt Validation")}}
                                    </label>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="max_login_attemtps">
                                                {{translate('Maximum Login Attempts')}} <small class="text-danger" >*({{translate('Per Minute')}})</small>
                                            </label>
                                            <input type="number" name="site_settings[max_login_attemtps]" id="max_login_attemtps" class="   " value="{{site_settings('max_login_attemtps')}}" required placeholder="max_login_attemtps">
                                        </div>
                                    </div>

                                    @if(site_settings("otp_expired_status") == App\Enums\StatusEnum::true->status() )
                                        <div class="col-lg-6">
                                            <div class="form-inner">
                                                <label for="otp_expired_in">
                                                    {{translate('Otp Expired Time')}} <small class="text-danger" >*({{translate('Minute')}})</small>
                                                </label>
                                                <input type="number" name="site_settings[otp_expired_in]" id="otp_expired_in" class="   " value="{{site_settings('otp_expired_in')}}" required placeholder="otp_expired_in">
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="loginSetting">
                                                {{translate('Login With')}}
                                                <small class="text-danger" >*</small>
                                            </label>
                                            <select class="select2" multiple id="loginSetting" name="site_settings[login_with][]">
                                                @foreach(Arr::get($authSetting,'login_with',[]) as $auth )
                                                        <option {{in_array($auth,$loginAttributes) ? "selected" :""}} value="{{$auth}}">{{$auth}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 d-none otp-section">
                                        <div class="form-inner ">
                                            <label for="otpVerification">
                                                {{translate('Sms Otp Verification')}}
                                                <span class="text-danger" >*</span>
                                            </label>

                                            <select class="select2" name="site_settings[sms_otp_verification]" id="otpVerification">

                                                @foreach( App\Enums\StatusEnum::toArray() as $key => $val)
                                                    <option {{site_settings('sms_otp_verification') ==  $val ? 'selected' :""}}  value="{{$val}}">
                                                        {{$key}}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div>
                                    <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                        {{translate("Submit")}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- logo settings tab  -->
                <div class="tab-pane fade" id="v-pills-logo" role="tabpanel" aria-labelledby="v-pills-logo-tab">
                    <form class="" data-route="{{route('admin.setting.logo.store')}}"  id="settingsForm"  method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="i-card-md">
                            <div class="card--header">
                                <h4 class="card-title">
                                    {{translate('Logo Settings')}}
                                </h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="site_logo">
                                                {{translate('Site Logo')}} <small class="text-danger" >*({{config("settings")['file_path']['site_logo']['size']}})</small>
                                            </label>
                                            <input type="file" name="site_settings[site_logo]" id="site_logo" class=" preview"  data-size = {{config("settings")['file_path']['site_logo']['size']}}>

                                            <div class="mt-2" id="image-preview-section">
                                                <img src="{{imageUrl(config("settings")['file_path']['site_logo']['path']."/".@site_logo('site_logo')->file->name ,@site_logo('site_logo')->file->disk ) }}" alt="{{site_settings('site_logo')}}"  class="bg-dark logo-preview">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="user_site_logo" >
                                                {{translate('Frontend Logo')}} <small class="text-danger" >* ({{config("settings")['file_path']['user_site_logo']['size']}})</small>
                                            </label>
                                            <input type="file" name="site_settings[user_site_logo]" id="user_site_logo" class=" preview" data-size = {{config("settings")['file_path']['user_site_logo']['size']}}>

                                            <div class="mt-2" id="image-preview-section">
                                                <img src="{{ imageUrl(config("settings")['file_path']['user_site_logo']['path']."/".@site_logo('user_site_logo')->file->name ,@site_logo('user_site_logo')->file->disk) }}" alt="{{site_settings('user_site_logo')}}" class="logo-preview">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="site_favicon">
                                                {{translate('Favicon')}} <small class="text-danger" >* ({{config("settings")['file_path']['favicon']['size']}})</small>
                                            </label>
                                            <input type="file" name="site_settings[site_favicon]" id="site_favicon" class=" preview" data-size = {{config("settings")['file_path']['favicon']['size']}}>
                                            <div class="mt-2" id="image-preview-section">
                                                <img src="{{ imageUrl(config("settings")['file_path']['favicon']['path']."/".@site_logo('site_favicon')->file->name ,@site_logo('site_favicon')->file->disk) }}" alt="{{site_settings('site_favicon')}}" class="fav-preview">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="i-btn btn--md btn--primary" anim="ripple">
                                            {{translate("Submit")}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('modal')

<div class="modal fade" id="cronjob" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable  modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-icon" id="exampleModalLabel">
                    {{translate('Cron Job Setup')}}
                </h5>
                <button class="close-btn" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label for="queue_url" class="form-label">{{translate('Queue')}} <span class="text-danger">* {{translate('Set time for 1 minute')}}</span></label>

                    <div class="input-group">
                        <input readonly class="form-control" value="curl -s {{route('queue.work')}}">
                        <button data-type="modal"  data-text ="curl -s {{route('queue.work')}}" class="copy-text btn btn-info" type="button"><i class="las la-copy"></i></button>
                    </div>

                </div>

                <div class="mb-3">
                    <label for="queue_url" class="form-label">{{translate('Cron Job ')}} <span class="text-danger">* {{translate('Set time for 1 minute')}}</span></label>

                    <div class="input-group">
                        <input readonly class="form-control" value="curl -s {{route('cron.run')}}">
                        <button data-type="modal" data-text ="curl -s {{route('cron.run')}}" class="copy-text btn btn-info" type="button"><i class="las la-copy"></i></button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="i-btn btn--md ripple-dark" anim="ripple" data-bs-dismiss="modal">
                    {{translate("Close")}}
                </button>

            </div>
        </div>
    </div>
</div>

@endsection

@push('style-include')

<link href="{{asset('assets/global/css/colorpicker.min.css')}}" rel="stylesheet">

@endpush
@push('script-include')

    <script src="{{asset('assets/global/js/colorpicker.min.js')}}"></script>

@endpush
@push('script-push')

<script>
  "use strict";
       $('.colorpicker').colorpicker();

	   check_login_settings($('#loginSetting').val())

        var count = "{{count($ticketSettings)-1}}";
        var counter = "{{count($registrationFormSettings)-1}}";
		// add more ticket option
		$(document).on('click','#add-ticket-option',function(e){
			count++
			var html = `<tr>
							<td data-label="{{translate("label")}}">
                                <div class="form-inner mb-0">
								   <input placeholder="{{translate("Enter Label")}}" type="text" name="ticket_setting[${count}][labels]" class=" ">
                                </div>
							</td>

							<td data-label="{{translate("Type")}}">
                                <div class="form-inner mb-0">
                                    <select class="form-select" name="ticket_setting[${count}][type]" id="">
                                        <option value="text">Text</option>
                                        <option value="email">Email</option>
                                        <option value="number">Number</option>
                                        <option value="date">Date</option>
                                        <option value="textarea">Textarea</option>
                                    </select>
                                </div>
							</td>

							<td data-label="{{translate("Required")}}">
                                <div class="form-inner mb-0">
                                    <select class="form-select" name="ticket_setting[${count}][required]" id="">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
							</td>

							<td data-label="{{translate("placeholder")}}">
                                <div class="form-inner mb-0">
                                    <input placeholder="{{translate("Enter Placeholder")}}"  type="text" name="ticket_setting[${count}][placeholder]" class="">
                                    <input  type="hidden" name="ticket_setting[${count}][default]" class="" value="0">
                                    <input  type="hidden" name="ticket_setting[${count}][multiple]" class="" value="0">
                                    <input  type="hidden" name="ticket_setting[${count}][name]" class="" value="">
                                </div>
							</td>

							<td data-label='{{translate("Option")}}'>
							   <div class="">
                                    <a href="javascript:void(0);" class="pointer icon-btn danger delete-option">
                                         <i class="las la-trash-alt"></i>
                                    </a>
                                </div>
							</td>

						</tr>`;
				$('#ticketField').append(html)

			e.preventDefault()
		})

		//delete ticket options
		$(document).on('click','.delete-option',function(e){
			$(this).closest("tr").remove()
			count--
			e.preventDefault()
		})

		$(document).on('click','#add-option',function(e){
			counter++
			var html = `<tr>
							<td data-label="{{translate("labels")}}">
                                <div class="form-inner mb-0">
								  <input  placeholder="{{translate("Enter Label")}}" type="text" name="registration[${counter}][labels]" class=" ">
                                </div>
							</td>

							<td data-label="{{translate("Order")}}">
                                <div class="form-inner mb-0">
								   <input type="number" name="registration[${counter}][order]" class="" >
                                </div>
							</td>

							<td data-label="{{translate("Width")}}">
                                <div class="form-inner mb-0">
                                    <select class="form-select"  name="registration[${counter}][width]" id="">
                                            <option  value="50">50%</option>
                                            <option  value="100">100%</option>
                                    </select>
                                </div>
							</td>


							<td data-label="{{translate("Status")}}">
                                <div class="form-inner mb-0">
                                    <select class="form-select"  name="registration[${counter}][status]" id="">
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                </div>
							</td>

							<td data-label="{{translate("Type")}}">
                                <div class="form-inner mb-0">
                                    <select class="form-select" name="registration[${counter}][type]" id="">
                                        <option value="text">Text</option>
                                        <option value="email">Email</option>
                                        <option value="number">Number</option>
                                        <option value="date">Date</option>
                                        <option value="textarea">Textarea</option>
                                        <option value="file">file</option>
                                    </select>
                                 </div>
							</td>
							<td  data-label="{{translate("Required")}}">
                                <div class="form-inner mb-0">
                                    <select class="form-select" name="registration[${counter}][required]" id="">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
							</td>
							<td  data-label="{{translate("placeholder")}}">
                                <div class="form-inner mb-0">
                                    <input  placeholder="{{translate("Enter placeholder")}}" type="text" name="registration[${counter}][placeholder]" class="">
                                    <input type="hidden" name="registration[${counter}][default]" class="" value="0">
                                    <input type="hidden" name="registration[${counter}][multiple]" class="" value="0">
                                    <input type="hidden" name="registration[${counter}][name]" class="" value="">
                                </div>

							</td>

							<td data-label="{{translate("Options")}}">
								<div>
                                    <a href="javascript:void(0);" class="pointer icon-btn danger delete-option">
                                         <i class="las la-trash-alt"></i>
                                    </a>
                                </div>
							</td>
						</tr>`;
				$('#registerFeild').append(html)

			e.preventDefault()
		})

		//delete registration form options
		$(document).on('click','.delete-register-option',function(e){
			$(this).closest("tr").remove()
			counter--
			e.preventDefault()
		})

        $(".select2").select2({
			laceholder:"{{translate('Select Option')}}",
	    })
        $(".select2-multi").select2({
			laceholder:"{{translate('Select Option')}}",
	    })

        $(document).on('change','#geo_location',function(e){
			 var trackBy = $(this).val();
			 if(trackBy == 'map_base'){
				$('#map-key').removeClass('d-none')
			 }
			 else{
				$('#map-key').addClass('d-none')
			 }
		})

		$(document).on('click','.reset-color',function(e){

			$("[name='site_settings[primary_color]']").val("{{Arr::get(config('site_settings'),'primary_color','#673ab7')}}")
			$("[name='site_settings[secondary_color]']").val("{{Arr::get(config('site_settings'),'secondary_color','#ba6cff')}}")
			$("[name='site_settings[text_primary]']").val("{{Arr::get(config('site_settings'),'text_primary','#26152e')}}");
			$("[name='site_settings[text_secondary]']").val("{{Arr::get(config('site_settings'),'text_secondary','#777777')}}")
			toastr("{{translate('Successfully Reseted To Base Color')}}",'success')

		});

		//same site name toggle
		$(document).on('click','#sameSiteName',function(e){
			if ($(this).prop('checked')) {
				$('.user-site-name').addClass('d-none')
				$('.site-name').removeClass('col-lg-6')
				$('.site-name').addClass('col-lg-12')
			}else{
				$('.site-name').removeClass('col-lg-12')
				$('.site-name').addClass('col-lg-6')
				 $('.user-site-name').removeClass('d-none')
			}

		})

		//csrf token setup
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		// update seettings
		$(document).on('submit','#settingsForm',function(e){
			 var data =   new FormData(this)
			 var route = "{{route('admin.setting.store')}}"
			 if($(this).attr('data-route')){
				route = $(this).attr('data-route')
			 }
			 $.ajax({
				method:'post',
				url: route,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				data: data,
				success: function(response){
					var className = 'success';
					if(!response.status){
						className = 'danger';
					}
					toastr( response.message,className)
				},
				error: function (error){
					if(error && error.responseJSON){
						if(error.responseJSON.errors){
							for (let i in error.responseJSON.errors) {
								toastr(error.responseJSON.errors[i][0],'danger')
							}
						}
						else{
							if((error.responseJSON.message)){
								toastr(error.responseJSON.message,'danger')
							}
							else{
								toastr( error.responseJSON.error,'danger')
							}
						}
					}
					else{
						toastr(error.message,'danger')
					}
				}
			})

			e.preventDefault();
		});

		// update seettings
		$(document).on('change','#loginSetting',function(e){
			check_login_settings($(this).val())
			e.preventDefault();
		});


		function check_login_settings(loginAttribute){
			$('.otp-section').addClass('d-none');
			if(Array.isArray(loginAttribute) && loginAttribute.length == 1 ){

				if(loginAttribute.includes("phone")){
					$('.otp-section').removeClass('d-none')
				}
			}
		}


</script>
@endpush
