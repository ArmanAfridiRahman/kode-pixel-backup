<!doctype html>
<html lang="{{App::getLocale()}}" dir="ltr" data-sidebar="open" color-scheme="light">
<head>
    <meta charset="utf-8" />
    <title>{{@site_settings("site_name")}} - {{@translate($title)}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ imageUrl(config("settings")['file_path']['favicon']['path']."/".@site_logo('site_favicon')->file->name ,@site_logo('site_favicon')->file->disk) }}" alt="{{@site_logo('site_favicon')->file->name}}">
    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/backend/css/main.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/toastr.css')}}" rel="stylesheet" type="text/css" />

    @include('partials.theme')
</head>

<body>

    
    <div class="form-section pt-100 pb-100">
        <div class="container">
            @yield('main_content')
        </div>
    </div>
    
    <script src="{{asset('assets/global/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/global/js/toastify-js.js')}}"></script>
    <script src="{{asset('assets/global/js/helper.js')}}"></script>
    <script src="{{asset('assets/global/js/font_awesome.js')}}"></script>

    @include('partials.notify')
    @stack('script-push')
</body>
</html>


