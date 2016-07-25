<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ trans('backend.media_manager') }}</title>
  <meta charset="utf-8">
  <link rel="icon shortcut" href="{{ asset('assets/img/fav.png') }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link href="{{ asset('assets/backend/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
    .image-item{
      padding-top: 15px;
padding-bottom: 15px;
    }
  @if(Lang::getlocale() == 'ar')
    @media screen and (min-width: 768px) {
    .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9 {
      float: right;
      direction: rtl;
    }
  }
  @endif
  </style>
  @yield('header')
</head>
<body>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      @if(Request::is(''.Lang::getlocale().'/media/browse/images'))
      <a href="/{{ Lang::getlocale() }}/media/upload/image" class="btn btn-success btn-block btn-lg" style="margin-top: 15px;">
        <i class="fa fa-plus"></i> {{ trans('backend.upload_new') }}
      </a>
      @elseif(Request::is(''.Lang::getlocale().'/media/upload/image'))
      <a href="/{{ Lang::getlocale() }}/media/browse/images" class="btn btn-warning btn-block btn-lg" style="margin-top: 15px;">
        <i class="fa fa-chevron-circle-left"></i> {{ trans('backend.back') }}
      </a>
      @elseif(Request::is(''.Lang::getlocale().'/media/browse/gallery'))
      <a href="/{{ Lang::getlocale() }}/media/upload/gallery" class="btn btn-success btn-block btn-lg" style="margin-top: 15px;">
        <i class="fa fa-plus"></i> {{ trans('backend.upload_new') }}
      </a>
      @elseif(Request::is(''.Lang::getlocale().'/media/upload/gallery'))
      <a href="/{{ Lang::getlocale() }}/media/browse/gallery" class="btn btn-warning btn-block btn-lg" style="margin-top: 15px;">
        <i class="fa fa-chevron-circle-left"></i> {{ trans('backend.back') }}
      </a>
      @endif
    </div>
  <div id="page-content-wrapper">
      <div class="container-fluid">
          <div class="row">
            <div class="col-sm-9">
                @if (Session::has('flash_notification.message'))
                    <div class="alert alert-{{ Session::get('flash_notification.level') }}">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('flash_notification.message') }}
                    </div>
                @endif

                @if ($errors->count() > 0)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
              @yield('paginate')
            </div>
          </div>
      </div>
  </div>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
 @yield('footer')
</body>
</html>
