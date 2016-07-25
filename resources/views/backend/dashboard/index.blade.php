@extends('backend.master')
@section('header')
    <!--page level css -->
    <link href="{{ asset('assets/backend/vendors/fullcalendar/css/fullcalendar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/css/pages/calendar_custom.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" media="all" href="{{ asset('assets/backend/vendors/jvectormap/jquery-jvectormap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/vendors/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/only_dashboard.css') }}" />
    <!--end of page level css-->
@endsection
@section('content-header')
<section class="content-header">
  <h1><i class="livicon" data-name="wrench" data-size="30" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>
   {{ trans('backend.welcome_site') }}
   </h1>
  <ol class="breadcrumb">
        <li class="active"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard') }}</li>
  </ol>   
</section>
@endsection
@section('content')
<!-- Include single delete confirmation model -->
@include('backend.contacts.confirm-delete')
<!-- end include single delete confirmation model -->  
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig">
        <!-- Trans label pie charts strats here-->
        <div class="lightbluebg no-radius">
            <div class="panel-body squarebox square_boxs">
                <div class="col-xs-12 pull-left nopadmar">
                    <div class="row">
                        <div class="square_box col-xs-7 text-right">
                            <span>{{ trans('backend.sites_total_visits') }}</span>
                            <div class="number" id="sites_total_visits"></div>
                        </div>
                        <i class="livicon  pull-right" data-name="eye-open" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInUpBig">
        <!-- Trans label pie charts strats here-->
        <div class="redbg no-radius">
            <div class="panel-body squarebox square_boxs">
                <div class="col-xs-12 pull-left nopadmar">
                    <div class="row">
                        <div class="square_box col-xs-7 text-right">
                            <span>{{ trans('backend.sites_web_visits') }}</span>
                            <div class="number" id="sites_web_visits"></div>
                        </div>
                        <i class="livicon  pull-right" data-name="eye-open" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInDownBig">
        <!-- Trans label pie charts strats here-->
        <div class="goldbg no-radius">
            <div class="panel-body squarebox square_boxs">
                <div class="col-xs-12 pull-left nopadmar">
                    <div class="row">
                        <div class="square_box col-xs-8 text-right">
                            <span>{{ trans('backend.sites_android_visits') }}</span>
                            <div class="number" id="sites_android_visits"></div>
                        </div>
                        <i class="livicon  pull-right" data-name="eye-open" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInRightBig">
        <!-- Trans label pie charts strats here-->
        <div class="palebluecolorbg no-radius">
            <div class="panel-body squarebox square_boxs">
                <div class="col-xs-12 pull-left nopadmar">
                    <div class="row">
                        <div class="square_box col-xs-8 text-right">
                            <span>{{ trans('backend.sites_ios_visits') }}</span>
                            <div class="number" id="sites_ios_visits"></div>
                        </div>
                        <i class="livicon  pull-right" data-name="eye-open" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/row-->

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig">
        <!-- Trans label pie charts strats here-->
        <div class="lightbluebg no-radius">
            <div class="panel-body squarebox square_boxs">
                <div class="col-xs-12 pull-left nopadmar">
                    <div class="row">
                        <div class="square_box col-xs-7 text-right">
                            <span>{{ trans('backend.news_total_visits') }}</span>
                            <div class="number" id="news_total_visits"></div>
                        </div>
                        <i class="livicon  pull-right" data-name="eye-open" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInUpBig">
        <!-- Trans label pie charts strats here-->
        <div class="redbg no-radius">
            <div class="panel-body squarebox square_boxs">
                <div class="col-xs-12 pull-left nopadmar">
                    <div class="row">
                        <div class="square_box col-xs-7 text-right">
                            <span>{{ trans('backend.news_web_visits') }}</span>
                            <div class="number" id="news_web_visits"></div>
                        </div>
                        <i class="livicon  pull-right" data-name="eye-open" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInDownBig">
        <!-- Trans label pie charts strats here-->
        <div class="goldbg no-radius">
            <div class="panel-body squarebox square_boxs">
                <div class="col-xs-12 pull-left nopadmar">
                    <div class="row">
                        <div class="square_box col-xs-8 text-right">
                            <span>{{ trans('backend.news_android_visits') }}</span>
                            <div class="number" id="news_android_visits"></div>
                        </div>
                        <i class="livicon  pull-right" data-name="eye-open" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInRightBig">
        <!-- Trans label pie charts strats here-->
        <div class="palebluecolorbg no-radius">
            <div class="panel-body squarebox square_boxs">
                <div class="col-xs-12 pull-left nopadmar">
                    <div class="row">
                        <div class="square_box col-xs-8 text-right">
                            <span>{{ trans('backend.news_ios_visits') }}</span>
                            <div class="number" id="news_ios_visits"></div>
                        </div>
                        <i class="livicon  pull-right" data-name="eye-open" data-l="true" data-c="#fff" data-hc="#fff" data-s="70"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/row-->

<div class="row ">
    <div class="col-md-6">
        <div class="panel panel-border">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="livicon" data-name="dashboard" data-size="20" data-loop="true" data-c="#F89A14" data-hc="#F89A14"></i>
                    {{ trans('backend.license') }} 
                    <small>{{ trans('backend.framework') }}</small>
                </h3>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <tbody>
                        <tr class="warning">
                            <td>{{ trans('backend.sowfware_category') }}</td>
                            <td>{{ trans('backend.sowfware_category_var') }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('backend.license') }}</td>
                            <td>{{ trans('backend.license_var') }}</td>
                        </tr>
                        <tr class="success">
                            <td>{{ trans('backend.specialty') }}</td>
                            <td>{{ trans('backend.specialty_var') }}</td>
                        </tr>
                        <tr class="warning">
                            <td>{{ trans('backend.code') }}</td>
                            <td>{{ trans('backend.code_var') }}</td>
                        </tr>
                        <tr>
                            <td>{{ trans('backend.date_of_issue') }}</td>
                            <td>{{ trans('backend.date_of_issue_var') }}</td>
                        </tr>
                        <tr class="danger">
                            <td>{{ trans('backend.copywite') }}</td>
                            <td>{{ trans('backend.copywite_var') }}</td>
                        </tr>
                         <tr class="warning">
                            <td>{{ trans('backend.last_update') }}</td>
                            <td>{{ trans('backend.last_update_var') }}</td>
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>
        </div>

        <div class="panel blue_gradiant_bg">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="livicon" data-name="linechart" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    {{ trans('backend.framework') }}
                    <small class="white-text">{{ trans('backend.counter') }}</small>
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 pull-left nopadmar">
                        <div class="row">
                            <div class="square_box col-md-12">
                                <div>
                                    <div class="col-md-4" style="text-align: center;">
                                        <span style="float: none;">{{ trans('backend.tourism_services') }}</span>
                                        <div style="float: none; text-align: center; font-size:18px;" class="number" id="tourism_services"></div>
                                    </div>
                                    <div class="col-md-4" style="text-align: center;">
                                        <span style="float: none;">{{ trans('backend.tourism_sites') }}</span>
                                        <div style="float: none; text-align: center; font-size:18px;" class="number" id="tourism_sites"></div>
                                    </div>
                                    <div class="col-md-4" style="text-align: center;">
                                        <span style="float: none;">{{ trans('backend.news') }}</span>
                                        <div style="float: none; text-align: center; font-size:18px;" class="number" id="news"></div>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="col-md-12">
                                <div class="pull-left" style="text-align: center; font-size: 20px;">
                                    <p style="padding-top: 7px;">{{ trans('backend.inno_thanks') }}</p>
                                </div>
                                <div class="pull-right" style="float: right !important;">
                                    <img src="{{ asset('assets/img/fav.png') }}" style="margin: 0 auto;">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                  </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-border">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="livicon" data-name="mail" data-size="20" data-loop="true" data-c="#F89A14" data-hc="#F89A14"></i>
                     {{ trans('backend.new_messages') }}
                    {{-- <small></small> --}}
                </h3>
            </div>
            <div class="panel-body" style="min-height: 500px;">
              <div class="table-responsive">
                @if($contacts->count())
                    <table class="table table-bordered">
                        <thead class="flip-content">
                            <tr>
                              <th>{{ trans('backend.from')}}</th>
                              <th>{{ trans('backend.phone')}}</th>
                              {{-- <th>{{ trans('backend.email')}}</th> --}}
                              <th>{{ trans('backend.message_subject')}}</th>
                              <th>{{ trans('backend.receive_date')}}</th>
                              <th>{{ trans('backend.operations')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($contacts as $contact)
                            <tr>
                              <td> {{ strip_tags(str_limit($contact->name, $limit = 15, $end = '...')) }} </td>
                              <td> {{ $contact->phone }} </td>
                              {{-- <td> {{ $contact->mail }} </td> --}}
                              <td>{{ strip_tags(str_limit($contact->subject, $limit = 15, $end = '...')) }} </td>
                              <td> {{ $contact->created_at }} </td>
                              <td>
                                  <a href="{{ action('ContactsController@show', $contact->id) }}"><i class="fa fa-eye"></i> {{ trans('backend.message_details')}}</a>
                                  @if($contact->reply_status == '0')
                                  <a href="{{ action('ContactsController@reply', $contact->id) }}"><i class="fa fa-reply"></i> {{ trans('backend.reply')}}</a>
                                  @endif
                                  <a onclick="confirmDelete(this)" data-toggle="modal" data-href="#full-width" data-id="{{ $contact->id }}" data-title="{{ $contact->subject }}" href="#full-width"><i class="fa fa-trash-o"></i> {{ trans('backend.delete') }}</a>
                              </td>
                            </tr>
                          @endforeach
                          </tbody>
                    </table>
                @else
                <h2 style="text-align: center;">{{ trans('backend.no_new_messages') }}</h2>
                @endif
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
    <!-- begining of page level js -->
    <!--  todolist-->
    <script src="{{ asset('assets/backend/js/todolist.js') }}"></script>
    <!-- EASY PIE CHART JS -->
    <script src="{{ asset('assets/backend/vendors/charts/easypiechart.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/charts/jquery.easypiechart.min.js') }}"></script>
    <!--for calendar-->
    <script src="{{ asset('assets/backend/vendors/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/backend/vendors/fullcalendar/calendarcustom.min.js') }}" type="text/javascript"></script>
    <!--   Realtime Server Load  -->
    <script src="{{ asset('assets/backend/vendors/charts/jquery.flot.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/backend/vendors/charts/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
    <!--Sparkline Chart-->
    <script src="{{ asset('assets/backend/vendors/charts/jquery.sparkline.js') }}"></script>
    <!-- Back to Top-->
    <script type="text/javascript" src="{{ asset('assets/backend/vendors/countUp/countUp.js') }}"></script>
    <!--   maps -->
    <script src="{{ asset('assets/backend/vendors/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
     <script src="{{ asset('assets/backend/vendors/jscharts/Chart.js') }}"></script>
    <script src="{{ asset('assets/backend/js/dashboard.js') }}" type="text/javascript"></script>
    
    <script type="text/javascript">
    $(document).ready(function() {
        var composeHeight = $('#calendar').height() +21 - $('.adds').height();
        $('.list_of_items').slimScroll({
            color: '#A9B6BC',
            height: composeHeight + 'px',
            size: '5px'
        });
    });
    </script>
<script type="text/javascript">
    // sites visits
    var sites_total_visits = {{ $sites_total_visits }};
    var demo = new countUp("sites_total_visits", 0, sites_total_visits, 0, 6, options);
    demo.start();

    var sites_web_visits = {{ $sites_web_visits }};
    var demo = new countUp("sites_web_visits", 0, sites_web_visits, 0, 6, options);
    demo.start();

    var sites_android_visits = {{ $sites_android_visits }};
    var demo = new countUp("sites_android_visits", 0, sites_android_visits, 0, 6, options);
    demo.start();

    var sites_ios_visits = {{ $sites_ios_visits }};
    var demo = new countUp("sites_ios_visits", 0, sites_ios_visits, 0, 6, options);
    demo.start();

    //news visits
    var news_total_visits = {{ $news_total_visits }};
    var demo = new countUp("news_total_visits", 0, news_total_visits, 0, 6, options);
    demo.start();

    var news_web_visits = {{ $news_web_visits }};
    var demo = new countUp("news_web_visits", 0, news_web_visits, 0, 6, options);
    demo.start();

    var news_android_visits = {{ $news_android_visits }};
    var demo = new countUp("news_android_visits", 0, news_android_visits, 0, 6, options);
    demo.start();

    var news_ios_visits = {{ $news_ios_visits }};
    var demo = new countUp("news_ios_visits", 0, news_ios_visits, 0, 6, options);
    demo.start();

    // counter
    var tourism_services = {{ $tourism_services }};
    var demo = new countUp("tourism_services", 0, tourism_services, 0, 6, options);
    demo.start();

    var tourism_sites = {{ $tourism_sites }};
    var demo = new countUp("tourism_sites", 0, tourism_sites, 0, 6, options);
    demo.start();

    var news = {{ $news }};
    var demo = new countUp("news", 0, news, 0, 6, options);
    demo.start();
</script>
<!--single delete item -->
<script type="text/javascript">
function confirmDelete(item) {
    var id = item.getAttribute("data-id");
    var title = item.getAttribute("data-title");

    $("#confirm-id").val(id);
    document.getElementById("confirm-title").innerHTML = title;
}
</script>
<!--end single delete item -->
    <!-- end of page level js -->

@endsection