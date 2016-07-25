@inject('Language', 'App\Http\Controllers\LanguageController')
@extends('backend.master')
@section('content-header')
<section class="content-header">
<h1><i class="livicon" data-name="ban" data-size="30" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>
الإعدادت</h1>
<ol class="breadcrumb">
    <li><a href="/{{ $Language->CurrentLang() }}/admin"><i class="fa fa-tachometer"></i> لوحة التحكم</a></li>
    <li class="active"><i class="fa fa-edit"></i> إعدادت وصال </li>
</ol>   
</section>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
   			<h3 class="panel-title"><i class="livicon" data-name="phone" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> إعدادت وصال </h3>
		</div>
		<div class="panel-body">
			<form action="{{ action('SettingsController@update_sms', $sms->id) }}" method="POST" role="form">
				<input type="hidden" name="_method" value="PATCH">
   				<input type="hidden" name="_token" value="{{ csrf_token() }}">

			
				<div class="form-group">
					<label for="url">Service Url</label>
					<input type="text" class="form-control" name="url" value="@if(old('url')){{ old('url') }}@else{{ $sms->url }}@endif" disabled>
				</div>

				<div class="form-group">
					<label for="username">user name</label>
					<input type="text" class="form-control" name="username" value="@if(old('username')){{ old('username') }}@else{{ $sms->username }}@endif">
				</div>

				<div class="form-group">
					<label for="passwoard">Password</label>
					<input type="text" class="form-control" name="passwoard" value="@if(old('passwoard')){{ old('passwoard') }}@else{{ $sms->passwoard }}@endif">
				</div>

				<div class="form-group">
					<label for="sender">Sender</label>
					<input type="text" class="form-control" name="sender" value="@if(old('sender')){{ old('sender') }}@else{{ $sms->sender }}@endif">
				</div>

				<button type="submit" class="btn btn-primary">تحديث</button>
			</form>
		</div>
	</div>
      </div>
</div>
@stop