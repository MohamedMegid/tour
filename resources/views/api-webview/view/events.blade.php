@extends('api-webview.view.master')
@section('header')
	<script src="{{ asset('assets/backend/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=places'></script>
	<script src="{{ asset('assets/gps/locationpicker.jquery.js') }}"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<style type="text/css">
.fb-share-button.fb_iframe_widget{
	margin-right: 5px;
    margin-bottom: 5px;
}
.skin-josh .navbar {
    background-color: #2C293A;
}
</style>
@endsection
@section('content')
	@if($events)
	<div class="row">
	    <div class="col-sm-12 col-md-12 col-full-width-right">
	    	@if($events->image)
	        <div class="blog-detail-image" style="background: #000;">
	            <img src="/{{ $events->image->file }}" class="img-responsive" alt="Image" style="margin: 0 auto; max-height: 450px;">
	        </div>
	        @endif
	        <!-- /.blog-detail-image -->
	        <div class="the-box no-border blog-detail-content">
	        	<h1>{{$events->title}}</h1>
	            <p>
	                <span class="label label-danger square">{{date('Y-m-d', strtotime($events->created_at))}}</span>
	            </p>
	            @if ($events->social_published == 1)
	            <div id="social-icons">
                    <table>
	                    <tr>
	                        <?php $url = $_SERVER['REQUEST_URI']; ?>
	                        <td>
		                        <div class="fb-share-button" data-href="http://tour.innocastle.com{{$url}}" data-layout="button_count"></div>
	                        </td>
	                        <td>
	                        	<a href="https://twitter.com/share" class="twitter-share-button" data-via="">Tweet</a>
	                        </td>
	                    </tr>
                    </table>
                </div>
                @endif
	            <p>
	                {{ trans('backend.startdate')}}: <span class="label label-success square">{{date('Y-m-d', strtotime($events->startdate))}}</span>
	                {{ trans('backend.enddate')}}:<span class="label label-danger square">{{date('Y-m-d', strtotime($events->enddate))}}</span>
	            </p>
	            <p>
	                {{ trans('backend.from')}}: <span class="label label-success square">{{$events->from}}</span>
	                {{ trans('backend.to')}}:<span class="label label-danger square">{{$events->to}}</span>
	            </p>
	            <p>
	                {{ trans('backend.city')}}: <span class="label label-success square">
	                @if ($cities->count())
		                @foreach ($cities as $city)
			                @if ($city->id == $events->city)
			                	{{$city->name}}
			                @endif
		                @endforeach
	                @endif
	            	</span>
	                {{ trans('backend.area')}}:<span class="label label-danger square">
	                @if ($areas->count())
		                @foreach ($areas as $area)
			                @if ($area->id == $events->area)
			                	{{$area->name}}
			                @endif
		                @endforeach
	                @endif
	            </span>
	            </p>
	            <p class="text-justify">
	                {{ trans('backend.address')}}: {{$events->address}}
	            </p>
	            <p class="text-justify">
	                {{ trans('backend.website')}}: {{$events->website}}
	            </p>
	            <p class="text-justify">
	                {{$events->details}}
	            </p>
	            <br /><br /><br />
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
                                                    خط العرض: <input type="text" id="latitude" value="{{$map->latitude}}" />
                                                </div>
                                                <div class="form-group">
                                                    خط الطول: <input type="text" id="longitude" value="{{$map->longitude}}" />
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
	        <!-- /the.box .no-border -->
	    </div>
	</div>
	@else
	<h1 style="text-align: center;">{{ trans('backend.bakend.page_not_found') }}</h2>
	@endif
@endsection
@section('footer')
@endsection