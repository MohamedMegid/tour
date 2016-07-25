@extends('backend.master')
@section('content-header')
<section class="content-header">
<h1><i class="livicon" data-name="ban" data-size="30" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>
{{ trans('backend.settings') }}</h1>
<ol class="breadcrumb">
    <li><a href="/{{ Lang::getlocale() }}/admin"><i class="fa fa-tachometer"></i> {{trans('backend.dashboard')}}</a></li>
    <li class="active"> {{ trans('backend.app_links') }} </li>
</ol>   
</section>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
   			<h3 class="panel-title"><i class="livicon" data-name="download" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> {{ trans('backend.app_links') }}  </h3>
		</div>
		<div class="panel-body">
			<form action="{{ action('SettingsController@update_app_links', $setting->id) }}" method="POST" role="form">
				<input type="hidden" name="_method" value="PATCH">
   				<input type="hidden" name="_token" value="{{ csrf_token() }}">

			
				<div class="form-group">
					<label for="apple">{{ trans('backend.apple_store') }}</label>
					<input type="text" class="form-control" name="apple" value="@if(old('apple')){{ old('apple') }}@else{{ $data->apple }}@endif">
				</div>

				<div class="form-group">
					<label for="google">{{ trans('backend.google_store') }}</label>
					<input type="text" class="form-control" name="google" value="@if(old('google')){{ old('google') }}@else{{ $data->google }}@endif">
				</div>

				<button type="submit" class="btn btn-primary">{{trans('backend.save_settings')}}</button>
			</form>
		</div>
	</div>
      </div>
</div>
@endsection