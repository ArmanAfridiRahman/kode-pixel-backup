
<div class="sidebar">
  <div class="sidebar-logo">
    <a href="{{route('admin.home')}}">
      <img
        src="{{ imageUrl(config("settings")['file_path']['site_logo']['path']."/".@site_logo('site_logo')->file->name ,@site_logo('site_logo')->file?->disk) }}"
        alt="{{@site_logo('site_logo')->file->name}}" />
    </a>
  </div>

  <div class="sidebar-menu-container" data-simplebar>
    <ul class="sidebar-menu">
      <li class="sidebar-menu-title">  {{translate(Arr::get(config("language"),'home'),"")}}</li>
     <!-- dashbaord section -->

        @if(check_permission('view_dashboard'))
          <li class="sidebar-menu-item">
              <a
                class="sidebar-menu-link {{sidebar_awake('admin.home')}}"
                anim="ripple"
                href="{{route("admin.home")}}"
                aria-expanded="false">
                <span><i class="las la-home"></i></span>
                <p> {{translate("Dashboard")}}</p>
              </a>
          </li>


        @endif

        <!-- staff & role-permission  section -->
        @if(check_permission('view_role') ||  check_permission('view_staff') )
          <li class="sidebar-menu-title">
            {{translate('Manage Staff')}}
          </li>
          <li class="sidebar-menu-item">
              <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#role_staff" role="button"
                aria-expanded="false" aria-controls="role_staff">
                <span><i class="las la-user-friends"></i></span>
                  <p>
                    {{translate('Staffs & Permissions')}}
                  </p>
                  <small class="">
                    <i class="las la-angle-down"></i>
                  </small>
              </a>

            <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.role.*','admin.staff.*'],'drop_down')}} " id="role_staff">
              <ul class="sub-menu">
                @if(check_permission('view_role'))
                  <li class="sub-menu-item">
                      <a class="sidebar-menu-link {{sidebar_awake('admin.role.*')}}" href="{{route('admin.role.list')}}">
                        <span></span>
                          <p>
                            {{translate('Roles & Permissions')}}
                          </p>
                      </a>
                  </li>
                @endif

                @if(check_permission('view_staff'))
                  <li class="sub-menu-item">
                    <a class="sidebar-menu-link  {{sidebar_awake('admin.staff.*')}}" href="{{route('admin.staff.list')}}">
                        <span></span>
                          <p>
                            {{translate('Staffs')}}
                          </p>
                    </a>
                  </li>
                @endif


              </ul>
            </div>
          </li>
        @endif

        @if(check_permission('view_ticket'))
          <li class="sidebar-menu-item">
              <a
                class="sidebar-menu-link {{sidebar_awake("admin.ticket.*")}} "
                anim="ripple"
                href="{{route("admin.ticket.list")}}"
                aria-expanded="false">
                <span><i class="las la-question-circle"></i></span>
                <p> {{translate("Support Tickets")}}
                    @if($pending_tickets > 0)
                      <span class="i-badge danger">{{$pending_tickets}}</span>
                    @endif
                </p>
              </a>
          </li>
       @endif



        <!-- Content section -->
        <li class="sidebar-menu-title">
            {{translate('Website Content')}}
        </li>

        <li class="sidebar-menu-item">
            <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#content" role="button"
              aria-expanded="false" aria-controls="content">
              <span><i class="las la-globe-europe"></i></span>
                <p>
                  {{translate('Manage Content')}}
                </p>
                <small class="">
                  <i class="las la-angle-down"></i>
                </small>
            </a>

          <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.service.*'],'drop_down')}} " id="content">
            <ul class="sub-menu">

              @if(check_permission('view_service'))

                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake("admin.service.list")}}"  href="{{route("admin.service.list")}}">
                      <span></span>
                      <p>
                        {{translate('Service Section')}}
                      </p>
                    </a>
                </li>

              @endif
              @if(check_permission('view_portfolio'))

                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake("admin.portfolio.list")}}"  href="{{route("admin.portfolio.list")}}">
                      <span></span>
                      <p>
                        {{translate('Portfolio Section')}}
                      </p>
                    </a>
                </li>

              @endif
              @if(check_permission('view_process'))

                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake("admin.process.list")}}"  href="{{route("admin.process.list")}}">
                      <span></span>
                      <p>
                        {{translate('Process Section')}}
                      </p>
                    </a>
                </li>

              @endif
              @if(check_permission('view_team'))
                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake("admin.team.list")}}"  href="{{route("admin.team.list")}}">
                      <span></span>
                      <p>
                        {{translate('Team Section')}}
                      </p>
                    </a>
                </li>
              @endif
              @if(check_permission('view_product'))
                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake("admin.product.list")}}"  href="{{route("admin.product.list")}}">
                      <span></span>
                      <p>
                        {{translate('Product Section')}}
                      </p>
                    </a>
                </li>
              @endif
            </ul>
          </div>
        </li>




        <!-- Frontend section -->
        <li class="sidebar-menu-title">
            {{translate('Website Control')}}
        </li>

        <li class="sidebar-menu-item">
            <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#frontend" role="button"
              aria-expanded="false" aria-controls="frontend">
              <span><i class="las la-globe-europe"></i></span>
                <p>
                  {{translate('Manage Frontend')}}
                </p>
                <small class="">
                  <i class="las la-angle-down"></i>
                </small>
            </a>

          <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.frontend.*','admin.seo.*','admin.client.*'],'drop_down')}} " id="frontend">
            <ul class="sub-menu">

              @if(check_permission('view_frontend'))

                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake("admin.frontend.list")}}"  href="{{route("admin.frontend.list")}}">
                      <span></span>
                      <p>
                        {{translate('Frontend Section')}}
                      </p>
                    </a>
                </li>

                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake("admin.seo.*")}}"  href="{{route("admin.seo.list")}}">
                      <span></span>
                      <p>
                        {{translate('Seo')}}
                      </p>
                    </a>
                </li>


                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake("admin.frontend.visitor")}}"  href="{{route("admin.frontend.visitor")}}">
                      <span></span>
                        <p>
                          {{translate('Visitors')}}
                        </p>
                    </a>
                </li>

              @endif
            </ul>
          </div>
        </li>




        <!-- template  section -->
        @if(check_permission('view_template'))

          <li class="sidebar-menu-title">
              {{translate('Notifications Template')}}
          </li>

          <li class="sidebar-menu-item">

            <a  class="sidebar-menu-link " data-bs-toggle="collapse" href="#templates" role="button"
              aria-expanded="false" aria-controls="templates">
              <span><i class="las la-bell"></i></span>
                <p>
                  {{translate('Templates')}}
                </p>
                <small class="">
                  <i class="las la-angle-down"></i>
                </small>
            </a>

            <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.template.*'],'drop_down')}} " id="templates">
              <ul class="sub-menu">

                  <li class="sub-menu-item">
                      <a class="sidebar-menu-link {{sidebar_awake(['admin.template.list',"admin.template.edit"])}}" href="{{route('admin.template.list')}}">
                        <span></span>
                          <p>
                              {{translate('Notification Template')}}
                          </p>
                      </a>
                  </li>

                  <li class="sub-menu-item">
                      <a class="sidebar-menu-link {{sidebar_awake('admin.template.global')}}" href="{{route('admin.template.global')}}">
                        <span></span>
                          <p>
                              {{translate('Global Template')}}
                          </p>
                      </a>
                  </li>

              </ul>

            </div>
          </li>

        @endif



        <!-- gateway  section -->
        @if(check_permission('view_gateway'))

          <li class="sidebar-menu-title">
              {{translate('Mail & Sms Settings')}}
          </li>
          <li class="sidebar-menu-item">
              <a class="sidebar-menu-link {{sidebar_awake("admin.mailGateway.*")}}"  href="{{route("admin.mailGateway.list")}}">
                <span><i class="las la-at"></i></span>
                  <p>
                    {{translate('Mail Gateway')}}
                  </p>
              </a>
          </li>
        @endif




      <!-- language section -->
      @if(check_permission('view_language'))
          <li class="sidebar-menu-title">
              {{translate('Language / Localizations')}}
          </li>
          <li class="sidebar-menu-item">
              <a class="sidebar-menu-link {{sidebar_awake("admin.language.*")}}"  href="{{route("admin.language.list")}}">
                <span><i class="las la-language"></i></span>
                <p>
                  {{translate('Language')}}
                </p>
              </a>
          </li>
      @endif


       <!-- settings  section -->
       @if(check_permission('view_settings'))
          <li class="sidebar-menu-title">
              {{translate('Adminstrator / Business')}}
          </li>

          <li class="sidebar-menu-item">

            <a  class="sidebar-menu-link" data-bs-toggle="collapse" href="#setting" role="button"
              aria-expanded="false" aria-controls="setting">
              <span><i class="las la-cog"></i></span>
                <p>
                  {{translate('Applications Settings')}}

                </p>
                <small class="">
                  <i class="las la-angle-down"></i>
                </small>
            </a>

            <div class="side-menu-dropdown collapse {{sidebar_awake(['admin.setting.*'],'drop_down')}} " id="setting">
              <ul class="sub-menu">
                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake("admin.setting.list")}}"  href="{{route("admin.setting.list")}}">
                      <span></span>
                      <p>
                        {{translate('App Settings')}}
                      </p>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a class="sidebar-menu-link {{sidebar_awake("admin.setting.configuration.*")}}"  href="{{route("admin.setting.configuration.index")}}">
                      <span></span>
                      <p>
                        {{translate('System Preferences')}}
                      </p>
                    </a>
                </li>

              </ul>

            </div>
          </li>
       @endif


      @if(check_permission('view_settings'))
        <li class="sidebar-menu-title">
            {{translate('Softwae Info')}}
        </li>

        <li class="sidebar-menu-item">
            <a class="sidebar-menu-link {{sidebar_awake("admin.setting.system.info")}}"  href="{{route("admin.setting.system.info")}}">
              <span><i class="lab la-accusoft"></i></span>
              <p>
                {{translate('Software Info')}}
              </p>
            </a>
        </li>
      @endif

    </ul>
  </div>
</div>
