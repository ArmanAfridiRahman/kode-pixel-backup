
<header class="header">
  <div class="header-container">
    <div class="d-flex align-items-center gap-lg-3 gap-2">
      <div class="header-icon">
        <button class="btn-icon vertical-menu-btn ripple-dark" anim="ripple">
          <i class="las la-bars"></i>
        </button>
      </div>
    </div>

    <div class="d-flex align-items-center gap-lg-3 gap-2">

      <div class="header-icon d-flex">
        <div class="btn-icon fullscreen-btn ripple-dark" anim="ripple">
          <i class="las la-expand"></i>
        </div>
      </div>

      <div class="header-icon d-flex">
        <div class="btn-icon ripple-dark" anim="ripple">
           <a href="{{route('admin.setting.cache.clear')}}">
              <i class="las la-broom"></i>
           </a>
        </div>
      </div>

      <div class="header-icon">
        <div class="btn-icon ripple-dark" anim="ripple">
           <a target="_blank" href="{{url('/')}}">
              <i class="las la-globe"></i>
           </a>
        </div>
      </div>


      {{-- @if(site_settings('database_notifications') ==  App\Enums\StatusEnum::true->status() && check_permission('view_notification'))
          @php
            $notifications = \App\Models\Notification::whereNull('user_id')->unread()->latest()->get();
          @endphp

          <div class="header-icon">
            <div class="notification-dropdown">
              @if($notifications->count() >0)
                <span>{{$notifications->count()}}</span>
              @endif
              <div class="btn-icon dropdown-toggle ripple-dark" anim="ripple"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="lar la-bell"></i>
              </div>
              <div class="dropdown-menu dropdown-menu-end">
                <div class="dropdown-menu-title">
                  <h6>
                      {{translate("Notification")}}
                  </h6>
                  <span class="i-badge success">{{$notifications->count()}} {{translate("New")}}   </span>
                </div>
                <div class="notification-items" data-simplebar>
                    <div class="notification-item">
                        <ul class="">
                          @forelse($notifications->take(6) as $notification)
                            <li>
                              <a href="javascript:void(0)" class="read-notification" data-id="{{$notification->id}}" data-href="{{$notification->url}}">
                                <div class="notify-icon">
                                  <img class="rounded-circle"
                                    src="{{imageUrl(config("settings")['file_path']['profile']['admin']['path']."/".@auth_user()->file->name ,@auth_user()->file->disk ) }}"
                                    alt="{{@auth_user()->file->name}}" />
                                </div>

                                <div class="notification-item-content">
                                  <h5> {{auth_user()->name}} <small>
                                      {{diff_for_humans($notification->created_at)}}
                                    </small></h5>
                                  <p>
                                      {{$notification->message}}
                                  </p>
                                </div>

                              </a>
                            </li>
                          @empty
                            <li class="text-center mx-auto mb-2">
                              <p>
                                {{translate("Nothing Found !!")}}
                              </p>
                            </li>
                          @endforelse

                        </ul>
                    </div>
                </div>

                  @if($notifications->count() >0)
                    <div class="dropdown-menu-footer">
                        <a href="{{route("admin.notifications")}}">
                           {{translate("View All")}}
                        </a>
                    </div>
                  @endif
              </div>
            </div>
          </div>
      @endif --}}

      <div class="header-icon">
        @php
          $lang = $languages->where('code',session()->get('locale'));

          $code = count($lang)!=0 ? $lang->first()->code:"en";
          $languages = $languages->where('code','!=',$code)->where('status',App\Enums\StatusEnum::true->status());
        @endphp
        <div class="lang-dropdown">
          <div class="btn-icon dropdown-toggle"
            data-bs-toggle="dropdown"
            aria-expanded="false">
            <img id="header-lang-img" class="flag-img" src="{{asset('assets/images/global/flags/'.strtoupper($code ).'.png') }}" alt="{{$code}}" height="20">
          </div>

          <div class="dropdown-menu dropdown-menu-end">
            <ul>
                @foreach($languages as $language)
                  <li>
                    <a href="{{route('language.change',$language->code)}}">
                      <img src="{{asset('assets/images/global/flags/'.strtoupper($language->code ).'.png') }}" alt="{{$language->code}}" class="">
                      {{$language->name}}
                    </a>
                  </li>
                @endforeach
            </ul>
          </div>
        </div>
      </div>

      <div class="header-icon">
        <div class="profile-dropdown">
          <div class="topbar-profile dropdown-toggle" type="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{imageUrl(config("settings")['file_path']['profile']['admin']['path']."/".@auth_user()->file->name ,@auth_user()->file->disk ) }}" alt="{{@auth_user()->file->name}}">
          </div>
          <div class="dropdown-menu dropdown-menu-end">
            <ul>
              <li>  <span class="dropdown-item">{{translate('Welcome')}} {{auth_user()->name}}!</span></li>

              <li>
                  <a class="dropdown-item" href="{{route('admin.profile.index')}}"> <i class="las la-cog"></i>
                    {{translate("Setting")}}
                  </a>
              </li>

              <li>

                  <a href="javascript:void(0)" class="pointer dropdown-item delete-item" data-message ='{{translate(Arr::get(config("language"),'sign_out'),"")}}' data-href="{{route('admin.logout')}}" >  <i class="las la-sign-out-alt"></i>
                    {{translate('logout')}}
                  </a>

              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

