@extends('backend.master')
@section('content-header')
<section class="content-header">
<h1><i class="livicon" data-name="ban" data-size="30" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>
{{ trans('backend.settings') }}</h1>
<ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard') }}</a></li>
    <li class="active"> {{ trans('backend.social_media_settings') }} </li>
</ol>   
</section>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
   			<h3 class="panel-title"><i class="livicon" data-name="mail" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> {{ trans('backend.social_media_settings') }} </h3>
		</div>
		<div class="panel-body">
			<form action="{{ action('SettingsController@update_social_media', $setting->id) }}" method="POST" role="form">
				<input type="hidden" name="_method" value="PATCH">
   				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="form-group">
					<label for="facebook">{{ trans('backend.facebook') }}</label>
					<input type="text" class="form-control" name="facebook" value="@if(old('facebook')){{ old('facebook') }}@else{{ $data->facebook }}@endif">
				</div>

				<div class="form-group">
					<label for="twitter">{{ trans('backend.twitter') }}</label>
					<input type="text" class="form-control" name="twitter" value="@if(old('twitter')){{ old('twitter') }}@else{{ $data->twitter }}@endif">
				</div>

				<button type="submit" class="btn btn-primary">{{ trans('backend.save_settings') }}</button>
			</form>
		</div>
	</div>
      </div>
</div>
@endsection