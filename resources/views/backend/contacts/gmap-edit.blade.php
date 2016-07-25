@extends('backend.master')
@section('header')
<script src="{{ asset('assets/backend/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=places'></script>
<script src="{{ asset('assets/gps/locationpicker.jquery.js') }}"></script>
@endsection
@section('content-header')
<!-- Main content -->
<section class="content-header">
    <h1><i class="livicon" data-name="list" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.edit') }} {{ trans('backend.gmap') }}</h1>
    <ol class="breadcrumb">
      <li><a href="/{{ Lang::getlocale() }}/admin"> {{ trans('backend.dashboard') }}</a></li>
      <li><a href="/{{ Lang::getlocale() }}/admin/contacts"> {{ trans('backend.list_contacts') }}</a></li>
      <li class="active"> {{ trans('backend.edit') }} {{ trans('backend.gmap') }}</li>
    </ol>   
</section>
</ol>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
         <div class="panel panel-primary" id="hidepanel1">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                    {{ trans('backend.edit') }} {{ trans('backend.gmap') }}
                                </h3>
                            </div>
                            @if (empty($gmap))
                            	<h3 class="panel-body">يجب اضافة الموقع اولا للقيام بعملية التعديل, للاضافة <a href="/admin/contact-us/gmap">صفحة الاضافة</a></h3>
                            @else
				                <div class="panel-body">
				                    <form action="{{ action('ContactsController@update', $gmap->id) }}" method="POST" role="form">
				                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
				                    	<div class="form-inline">
					                        <div class="form-group">
					                       		{{ trans('backend.location') }}: <input type="text" id="us2-address" style="width: 500px;" name="address" />
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
				                        <div class="form-group">
				                            <button type="submit" class="btn btn-block btn-primary">{{ trans('backend.update') }}</button>
				                        </div>
				                    </form>
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
							@endif
        </div>
    </div>
</div></div>
@endsection
@section('footer')
	
@endsection