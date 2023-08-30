
<!DOCTYPE html>
<html lang="{{App::getLocale()}}" data-sidebar="open">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{csrf_token()}}" />
 
    <title>{{@site_settings("site_name")}} - {{@translate($title)}}</title>
    <link rel="shortcut icon" href="{{ imageUrl(config("settings")['file_path']['favicon']['path']."/".@site_logo('site_favicon')->file->name ,@site_logo('site_favicon')->file?->disk) }}" alt="{{@site_logo('site_favicon')->file?->name}}">
    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/bootstrap-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/line-awesome.min.css')}}" rel="stylesheet"  type="text/css"/>
    <link href="{{asset('assets/global/css/nice-select.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/backend/css/simplebar.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/dataTables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/backend/css/main.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/toastr.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/backend/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/custom.css')}}" rel="stylesheet" type="text/css" />

    @include('partials.theme')
    @stack('style-include')
    @stack('styles')

  </head>

  <body>

    @include('admin.partials.topbar')
    @include('modal.delete_modal')
    
    <div class="dashboard-wrapper">
      @include('admin.partials.sidebar')
        <div class="main-content">
            @if(!request()->routeIs('admin.home'))
                @include('admin.partials.breadcrumb')
            @endif
            @yield('content')
        </div>

      @yield("modal")
    
    </div>

    <script src="{{asset('assets/global/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/global/js/simplebar.min.js')}}"></script>
    <script  src="{{asset('assets/global/js/dataTables.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/app.js')}}"></script>
    <script src="{{asset('assets/global/js/main.js')}}"></script>
    <script  src="{{asset('assets/global/js/nice-select.min.js')}}"></script>
    <script src="{{asset('assets/global/js/select2.min.js')}}"></script>
    <script  src="{{asset('assets/global/js/toastify-js.js')}}"></script>
    <script src="{{asset('assets/global/js/helper.js')}}"></script>
    <script src="{{asset('assets/global/js/pusher.min.js')}}"></script>
    <script src="{{asset('assets/global/js/push.js')}}"></script>

    @include('partials.notify')
    @stack('script-include')
    @stack('script-push')


    <script>

    (function($){
        "use strict";

      // update status event start
      $(document).on('click', '.status-update', function (e) {
        
            const id = $(this).attr('data-id')
            const key = $(this).attr('data-key')
            var column = ($(this).attr('data-column'))
            var route = ($(this).attr('data-route'))
            var modelName = ($(this).attr('data-model'))
            var status = ($(this).attr('data-status'))
            const data = {
                'id': id,
                'model': modelName,
                'column': column,
                'status': status,
                'key': key,
            }
          updateStatus(route, data)
      })
    
      // update status method
      function updateStatus(route, data) {
          var responseStatus;
          $.ajax({
              method: 'POST',
              url: route,
              data: {
                  "_token" :"{{csrf_token()}}",
                  data
              },
              dataType: 'json',
              success: function (response) {

                  if (response) {
                      responseStatus = response.status? "success" :"danger"
                      toastr(response.message,responseStatus)
                      if(response.reload){
                          location.reload()
                      }
                  } 
              },
              error: function (error) {
                  if(error && error.responseJSON){
                      if(error.responseJSON.errors){
                          for (let i in error.responseJSON.errors) {
                              toastr(error.responseJSON.errors[i][0],'danger')
                          }
                      }
                      else{
                          toastr( error.responseJSON.error,'danger')
                      }
                  }
                  else{
                      toastr("This Function is Not Avaialbe For Website Demo Mode",'danger')
                  }
              }
          })
      }


        // read notification
        $(document).on('click','.read-notification',function(e){
            var href = $(this).attr('data-href')
            var id = $(this).attr('data-id')
            readNotification(href,id)
            e.preventDefault()
        })
            
        // read Notification
        function readNotification(href,id){
            $.ajax({
                method:'post',
                url: "{{route('admin.read.notification')}}",
                data:{
                    "_token": "{{ csrf_token()}}",
                    'id':id
                },
                dataType: 'json'
                }).then(response =>{
                if(!response.status){
                    toastr(response.message,'danger')
                }
                else{
                    window.location.href = href
                }}).fail((jqXHR, textStatus, errorThrown) => {
                    toastr(jqXHR.statusText, 'danger');
                });
        }

    })(jQuery);


    </script>

  </body>

</html>
