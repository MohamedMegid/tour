@inject('Language', 'App\Http\Controllers\LanguageController') 
@extends('backend.master')
@section('header')

@endsection
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="list" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.edit') }} {{ trans('backend.Map Tracks') }}</h1>
    <ol class="breadcrumb">
      <li><a href="/{{ Lang::getlocale() }}/admin"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard') }}</a></li>
      <li class="active"> {{ trans('backend.edit') }} {{ trans('backend.Map Tracks') }}</li>
    </ol>   
</section>
@endsection

@section('content')
<!-- Include Media model -->
@include('backend.media.model.model')
<!-- end include Media model -->
@if (!empty($map))
<div class="row">
     <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
               <h3 class="panel-title"><i class="livicon" data-name="list" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> {{ trans('backend.edit') }} {{ trans('backend.Map Tracks') }}</h3>
            </div>
            <div class="panel-body">
                <form action="{{ action('MapTracksController@update') }}" method="POST" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @include('backend.media.fields.main-image-field')
                    <button type="submit" class="btn btn-block btn-primary">{{ trans('backend.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@else
    <a href="/{{$Currentlanguage}}/admin/maptracks/create" style="font-size: 25px;padding: 50px;">{{ trans('backend.GO TO ADD PAGE') }}</a>
@endif

@endsection
@section('footer')
<!--Media -->
@include('backend.media.scripts.scripts')
<!--end media -->

@endsection