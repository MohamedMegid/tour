@inject('Language', 'App\Http\Controllers\LanguageController') 
@extends('backend.master')
@section('header')
<script src="{{ asset('assets/backend/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=places'></script>
<script src="{{ asset('assets/gps/locationpicker.jquery.js') }}"></script>
@endsection
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="list" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.create') }} {{ trans('backend.site') }}</h1>
    <ol class="breadcrumb">
      <li><a href="/{{ Lang::getlocale() }}/admin"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard') }}</a></li>
      <li><a href="/{{ Lang::getlocale() }}/admin/sites/{{$type}}"> {{ trans('backend.list_sites') }}</a></li>
      <li class="active"> {{ trans('backend.create') }} {{ trans('backend.site') }}</li>
    </ol>   
</section>
@endsection

@section('content')
<!-- Include Media model -->
@include('backend.media.model.model')
<!-- end include Media model -->

<!-- Include Media model -->
@include('backend.media.model.gallery-model')
<!-- end include Media model -->
<div class="row">
     <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
               <h3 class="panel-title"><i class="livicon" data-name="list" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> {{ trans('backend.create') }} {{ trans('backend.site') }}</h3>
            </div>
            <div class="panel-body">
                <form action="{{ action('SitesController@store', $type) }}" method="POST" role="form">
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
                                    <label for="summary">{{ trans('backend.summary') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                    <textarea name="summary_{{$lang->code}}" id="input" class="form-control" rows="5">{{ old('summary_'.$lang->code.'') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="description">{{ trans('backend.description') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                    <textarea name="description_{{$lang->code}}" id="input" class="form-control" rows="5">{{ old('description_'.$lang->code.'') }}</textarea>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="livicon" data-name="map" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> {{ trans('backend.location') }}</h3>
                            </div>

                            <div class="panel-body">
                                    <div class="form-group">
                                        <label>{{ trans('backend.site_search') }}</label>
                                        <input type="text" class="form-control" id="us3-address"/>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label class="col-sm-2 control-label">Radius:</label>

                                        <div class="col-sm-5"><input type="text" class="form-control" id="us3-radius"/></div>
                                    </div> --}}
                                    <div id="us3" style="width: 100%; height: 400px;"></div>
                                    <p class="help-block"> {{ trans('backend.Note: You should put the marker at your location') }}</p>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class=" form-inline">
                                            <div class="form-group">
                                              <label for="latitude">{{ trans('backend.latitude') }}</label>
                                                  <input type="text" name="latitude" class="form-control" id="us3-lat"/>
                                            </div>
                                            <div class="form-group">
                                               <label for="longitude">{{ trans('backend.longitude') }}</label>
                                               <input type="text" name="longitude" class="form-control" id="us3-lon"/>
                                            </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    {{-- Location map --}}
                                        <script>$('#us3').locationpicker({
                                            location: {latitude: 24.966243570682984, longitude: 46.5293573125},
                                            radius: 0,//defualt 300
                                            zoom: 18,
                                            inputBinding: {
                                                latitudeInput: $('#us3-lat'),
                                                longitudeInput: $('#us3-lon'),
                                                radiusInput: $('#us3-radius'),
                                                locationNameInput: $('#us3-address')
                                            },
                                            enableAutocomplete: true,
                                            onchanged: function (currentLocation, radius, isMarkerDropped) {
                                                // Uncomment line below to show alert on each Location Changed event
                                                //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");
                                            }
                                        });</script>
                                    {{-- end Location map --}} 
                            </div>
                        </div>
                        <!-- Media Gallery -->
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="image" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                    {{ trans('backend.photo_gallery') }}
                                </h3>
                            </div>
                            <div class="panel-body">
                                @include('backend.media.fields.gallery-field')
                            </div>
                        </div>
                        <!-- End Media Gallery -->
                    </div>
                    <div class="col-md-3 sidbare">
                        <!-- Language field -->
                        @if($Language->all()->count())
                            <div class="form-group">
                                <label  style="text-align: center; width:100%;">{{ trans('backend.languages') }}</label>
                                @foreach($Language->all() as $key => $lang)
                                <div class="checkbox">
                                    <label for="checkboxes-0">
                                      <input type="checkbox" name="language[{{$key}}]" id="lang-{{$lang->code}}" value="{{$lang->code}}" checked>
                                      {{$lang->name}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        @endif
                        <!-- End Language field -->

                        <!-- Media main image -->
                        @include('backend.media.fields.main-image-field')
                        <!-- End Media main image -->
                        
                        @if($sections->count())
                        <div class="form-group">
                            <label for="" style="display:block;">{{ trans('backend.section') }}</label>
                            <select name="section" class="form-control">
                                <option value="">- {{ trans('backend.select') }} -</option>
                                @foreach($sections as $section)
                                @if($section->trans)
                                    <option value="{{ $section->id }}" @if(old('section') == $section->id) selected @endif> {{ $section->trans->name }}</option>
                                @endif 
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="form-group">
                            <div class="checkbox">
                                <label><input name="published" type="checkbox" value="1" class="minimal-blue" checked> {{ trans('backend.published') }}</label>
                            </div>
                            <div class="checkbox">
                                <label><input name="important_site" type="checkbox" value="1" class="minimal-blue" checked> {{ trans('backend.important_site') }}</label>
                            </div>
                            <div class="checkbox">
                                <label><input name="feature_site" type="checkbox" value="1" class="minimal-blue" @if(old('feature_site') == 1) checked @endif> {{ trans('backend.feature_site') }}</label>
                            </div>
                            <div class="checkbox">
                                <label><input name="social_published" type="checkbox" value="1" class="minimal-blue" checked> {{ trans('backend.social_published') }}</label>
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
@endsection