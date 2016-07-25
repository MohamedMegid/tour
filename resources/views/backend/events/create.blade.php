@inject('Language', 'App\Http\Controllers\LanguageController') 
@extends('backend.master')
@section('header')
<!--piker for time filter -->
<script src="{{ asset('assets/backend/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=places'></script>
<script src="{{ asset('assets/gps/locationpicker.jquery.js') }}"></script>

<link href="{{ asset('assets/backend/vendors/timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/backend/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen" />
<!--end piker for time filter -->
<!--choosen -->
<link rel="stylesheet" href="{{ asset('assets/backend/custom/chosen/chosen.css')}}">
<!--end choosen -->
@endsection
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="list" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.create') }} {{ trans('backend.events') }}</h1>
    <ol class="breadcrumb">
      <li><a href="/{{ Lang::getlocale() }}/admin"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard') }}</a></li>
      <li><a href="/{{ Lang::getlocale() }}/admin/events"> {{ trans('backend.list_events') }}</a></li>
      <li class="active"> {{ trans('backend.create') }} {{ trans('backend.events') }}</li>
    </ol>   
</section>
@endsection

@section('content')
<!-- Include Media model -->
@include('backend.media.model.model')
<!-- end include Media model -->
<div class="row">
     <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
               <h3 class="panel-title"><i class="livicon" data-name="list" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> {{ trans('backend.create') }} {{ trans('backend.events') }}</h3>
            </div>
            <div class="panel-body">
                <form action="{{ action('EventsController@store') }}" method="POST" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-9">
                        @if($Language->all()->count())
                            @foreach($Language->all() as $lang)
                            <div id="group-{{$lang->code}}">
                                <div class="form-group">
                                    <label for="title">{{ trans('backend.title') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                    <input type="text" class="form-control" name="title_{{$lang->code}}" value="{{ old('title_'.$lang->code.'') }}" placeholder="{{ trans('backend.title') }} @if($Language->all()->count() > '1') {{ $lang->name }} @endif">
                                </div>

                                <div class="form-group">
                                    <label for="details">{{ trans('backend.details') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                    <textarea name="details_{{$lang->code}}" id="input" class="form-control" rows="5">{{ old('details_'.$lang->code.'') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="address">{{ trans('backend.address') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                    <input type="text" class="form-control" name="address_{{$lang->code}}" value="{{ old('address_'.$lang->code.'') }}" placeholder="{{ trans('backend.address') }} @if($Language->all()->count() > '1') {{ $lang->name }} @endif">
                                </div>
                            </div>
                                @endforeach
                        @endif

                                <div class="form-group">
                                    <label for="website">{{ trans('backend.website') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                    <input type="text" class="form-control" name="website" value="{{ old('website') }}" placeholder="{{ trans('backend.website') }}">
                                </div>
                                <label for="Date">{{ trans('backend.Date') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                <div class="form-group">
                                    <label>{{ trans('backend.startdate') }}</label>
                                     <div class="input-group date form_datetime-1" data-date="{{ date('Y-m-d') }}" data-date-format="dd mm yyyy" data-link-field="dtp_input1">
                                       <input size="16" type="text" value="" readonly class="form-control" name="startdate">
                                       <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-th"></span>
                                       </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('backend.enddate') }}</label>
                                     <div class="input-group date form_datetime-1" data-date="{{ date('Y-m-d') }}" data-date-format="dd mm yyyy" data-link-field="dtp_input1">
                                       <input size="16" type="text" value="" readonly class="form-control" name="enddate">
                                       <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-th"></span>
                                       </span>
                                    </div>
                                </div>
                                <label for="Date">{{ trans('backend.appointment') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                <div class="form-group">
                                    <label for="from">{{ trans('backend.from') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                    <input type="text" class="form-control" name="from" value="{{ old('from') }}" placeholder="{{ trans('backend.from') }}">
                                </div>
                                <div class="form-group">
                                    <label for="to">{{ trans('backend.to') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                    <input type="text" class="form-control" name="to" value="{{ old('to') }}" placeholder="{{ trans('backend.to') }} ">
                                </div>

                                @if($cities->count())
                                <div class="form-group" id="menu-group">
                                    <label for="body">{{ trans('backend.city') }}</label>
                                    <select name="city" class="form-control city_related">
                                        <option value="">-- {{ trans('backend.select') }} --</option>
                                        @foreach($cities as $city)
                                        <option class="city_related" value="{{ $city->id }}" @if(old('city')== $city->id) selected @endif>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif

                               
                                <div class="form-group" id="menu-group">
                                    <label for="body">{{ trans('backend.area') }}</label>
                                    <select name="area" class="form-control" id="areas">
                                        <option value="0">-- {{ trans('backend.select') }} --</option>
                                        
                                    </select>
                                </div>
                               


                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="livicon" data-name="map" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> {{ trans('backend.location') }}</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-inline">
                                            <div class="form-group">
                                                {{ trans('backend.location') }}: <input type="text" id="us2-address" style="width: 350px;" name="address" />
                                            </div>
                                            <div class="form-group">
                                                {{ trans('backend.Dimension') }}: <input type="text" id="us2-radius"/>
                                            </div>
                                        </div><br>
                                        <div class="form-group">
                                            <div id="us2" style="width: 100%; height: 400px;"></div>
                                        </div>
                                        <div class="form-inline">
                                            <div class="form-group">
                                                {{ trans('backend.latitude') }}: <input type="text" id="us2-lat" name="latitude" />
                                            </div>
                                            <div class="form-group">
                                                {{ trans('backend.longitude') }}: <input type="text" id="us2-lon" name="longitude" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <p style="color:#e9573f;">{{ trans('backend.Note: You should put the marker at your location') }}</p>
                                        </div>
                                        <div  class="transfer">
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    العنوان: <input type="text" id="address" value="" />
                                                </div>
                                                <div class="form-group">
                                                    خط العرض: <input type="text" id="latitude" value="29.98203391536195" />
                                                </div>
                                                <div class="form-group">
                                                    خط الطول: <input type="text" id="longitude" value="31.27560329437256" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $('.transfer').hide();
                                        $('#us2').locationpicker({
                                            location: {latitude: $('#latitude').val(), longitude: $('#longitude').val()},   
                                            radius: 3000,
                                            inputBinding: {
                                                latitudeInput: $('#us2-lat'),
                                                longitudeInput: $('#us2-lon'),
                                                radiusInput: $('#us2-radius'),
                                                locationNameInput: $('#us2-address')
                                            }
                                        });
                                    </script>
                                </div>
                    </div>
 
                            
                    <div class="col-md-3 sidbare">
                        <!-- Language field -->
                        @include('backend.language.field')
                        <!-- End Language field -->

                        <!-- Media main image -->
                        @include('backend.media.fields.main-image-field')
                        <!-- End Media main image -->

                        <div class="form-group">
                            <div class="checkbox">
                                <label><input name="social_published" type="checkbox" value="1" class="minimal-blue" @if(old('social_published') == 1) checked @endif> {{ trans('backend.social_published') }}</label>
                            </div>
                            <div class="checkbox">
                                <label><input name="back" type="checkbox" value="1" class="minimal-blue" @if(old('back') == 1) checked @endif> {{ trans('backend.add_new_after_save') }}</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-primary">{{ trans('backend.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer')

<!--Language -->
@include('backend.language.scripts.scripts')
<!--end Language -->

<!--Media -->
@include('backend.media.scripts.scripts')
<!--end media -->

<!--datetime picker for time filter-->
<script src="{{ asset('assets/backend/vendors/timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/vendors/datetimepicker/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('assets/backend/vendors/datetimepicker/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8"></script>
<script src="{{ asset('assets/backend/js/pages/pickers.js') }}"></script>
<!--end datetime picker for time filter-->

<!-- choosen -->
<script src="{{ asset('assets/backend/custom/chosen/chosen.jquery.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
</script>

<script>
        $("document").ready(function(){
            $(".city_related").change(function(){
                var city = 0;
                city = $(".city_related").val();
                if (city == ''){
                    city = 0;
                }
                var data = 'city='+city; 
                var items = '';
                
                $('#areas')
                        .find('option:gt(0)')
                        .remove()
                        .end();

                
                $.getJSON("/admin/getareas/" + city, function(data){
                    $.each( data, function( key, val ) {
                    $('#areas')
                        .append("<option value="+val.id+">"+val.name+"</option>");
                    });
                });

            });
        });//end of document ready function
    </script>



@endsection