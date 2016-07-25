<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ trans('backend.project_name') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans|Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('assets/web-view/banner/demo/css/demostyles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/web-view/banner/css/simple-slideshow-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/web-view/banner/css/custom-api.css') }}">
  </head>
  <body>
            <div class="bss-slides num1" tabindex="1" autofocus="autofocus">
              @foreach($banners as $banner)
              @if($banner->image)
                <figure>
                 <a href="{{ $banner->link }}"> <img src="/{{ $banner->image->file }}" width="100%" /></a>
                     <!-- <figcaption>
                            caption here <a href="https://www.mahmoudeid.net/">Mahmoud Eid Codes</a>.
                      </figcaption> -->
                </figure>
                @endif
              @endforeach
            </div> <!-- // bss-slides -->

    <script src="{{ asset('assets/web-view/banner/demo/js/hammer.min.js') }}"></script><!-- for swipe support on touch interfaces -->
    <script src="{{ asset('assets/web-view/banner/js/better-simple-slideshow.min.js') }}"></script>
    <script>
    var opts = {
        auto : {
            speed : 3500, 
            pauseOnHover : true
        },
        fullScreen : false, 
        swipe : true
    };
    makeBSS('.num1', opts);
    </script>
  </body>
</html>