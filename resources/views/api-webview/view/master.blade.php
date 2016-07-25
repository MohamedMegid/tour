@inject('Language', 'App\Http\Controllers\LanguageController') 
@inject('Webview', 'App\Http\Controllers\WebviewController') 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ trans('backend.project_name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="icon shortcut" href="{{ asset('assets/img/fav.png') }}">
    <!-- global css -->
    <link href="{{ asset('assets/backend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="{{ asset('assets/backend/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/css/styles/black.css') }}" rel="stylesheet" type="text/css" id="colorscheme" />

    <link rel="stylesheet" href="{{ asset('assets/backend/css/panel.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/metisMenu.css') }}" />
    <!-- end of global css -->
    <!--page level css-->
{{--     <link href="{{ asset('assets/backend/css/pages/tables.css') }}" rel="stylesheet" /> 
    <script src="{{ asset('assets/backend/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>--}}

    <link href="{{ asset('assets/backend/css/inno-custom.css') }}" rel="stylesheet" type="text/css" id="colorscheme" />
    @if(Lang::getLocale() == 'ar')
        <link href="{{ asset('assets/backend/css/custom-rtl.css') }}" rel="stylesheet" type="text/css" id="colorscheme" />
        <link href="{{ asset('assets/backend/css/pages/tables-rtl.css') }}" rel="stylesheet" />
    @endif

    @yield('header')
    <!--end of page level css-->
</head>

<body class="skin-josh">
    <header class="header">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-left: 0; margin-right:0;">
            <div style="text-align: center;">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
            </div>
            
        </nav>
    </header>
    <section class="content">
        <!-- Include model -->
        @include('api-webview.view.model')
        <!-- end include model --> 
        @yield('content')
    </section>
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
        <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
    </a>
    <!-- global js -->
    <script src="{{ asset('assets/backend/js/jquery-1.11.1.min.js') }}"></script>
    {{--@if (Request::is('admin/form_builder2') || Request::is('admin/gridmanager') || Request::is('admin/portlet_draggable'))
        <script src="{{ asset('assets/backend/vendors/form_builder1/js/jquery.ui.min.js') }}"></script>
    @endif--}}
    <script src="{{ asset('assets/backend/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <!--livicons-->
    <script src="{{ asset('assets/backend/vendors/livicons/minified/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/livicons/minified/livicons-1.4.min.js') }}"></script>

    <script src="{{ asset('assets/backend/js/josh.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/backend/js/metisMenu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/backend/vendors/holder-master/holder.js') }}"></script>
    <!-- end of global js -->

    <!--Model -->
    <script src="{{ asset('assets/backend/js/bulkselect.js') }}"></script>

    <script src="{{ asset('assets/backend/vendors/modal/js/classie.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/modal/js/modalEffects.js') }}"></script>
    <script type="text/javascript">
    $(window).load(function(){
        $('#download').modal('show');
    });
</script>
    <!--end model -->
    <!-- begin page level js -->
@yield('footer')
    <!-- end page level js -->
  
</body>
</html>