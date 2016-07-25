@extends('backend.master')
@section('content-header')
<section class="content-header">
<h1><i class="livicon" data-name="ban" data-size="30" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>
{{ trans('backend.settings') }}</h1>
<ol class="breadcrumb">
    <li><a href="/{{ Lang::getlocale() }}/admin"><i class="fa fa-tachometer"></i> {{trans('backend.dashboard')}}</a></li>
    <li class="active"><i class="fa fa-edit"></i> Smtp Settings </li>
</ol>   
</section>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
   			<h3 class="panel-title"><i class="livicon" data-name="mail" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> Smtp Settings </h3>
		</div>
		<div class="panel-body">
			<form action="{{ action('SettingsController@update_mail', $setting->id) }}" method="POST" role="form">
				<input type="hidden" name="_method" value="PATCH">
   				<input type="hidden" name="_token" value="{{ csrf_token() }}">

			
				<div class="form-group">
					<label for="driver">driver</label>
					<input type="text" class="form-control" name="driver" value="@if(old('driver')){{ old('driver') }}@else{{ $data->driver }}@endif">
				</div>

				<div class="form-group">
					<label for="host">host</label>
					<input type="text" class="form-control" name="host" value="@if(old('host')){{ old('host') }}@else{{ $data->host }}@endif">
				</div>

				<div class="form-group">
					<label for="port">port</label>
					<input type="text" class="form-control" name="port" value="@if(old('port')){{ old('port') }}@else{{ $data->port }}@endif">
				</div>

				<div class="form-group">
					<label for="address">address</label>
					<input type="text" class="form-control" name="address" value="@if(old('address')){{ old('address') }}@else{{ $data->address }}@endif">
				</div>

				<div class="form-group">
					<label for="name">name</label>
					<input type="text" class="form-control" name="name" value="@if(old('name')){{ old('name') }}@else{{ $data->name }}@endif">
				</div>

				<div class="form-group">
					<label for="encryption">encryption</label>
					<input type="text" class="form-control" name="encryption" value="@if(old('encryption')){{ old('encryption') }}@else{{ $data->encryption }}@endif">
				</div>

				<div class="form-group">
					<label for="user_name">user name</label>
					<input type="text" class="form-control" name="user_name" value="@if(old('user_name')){{ old('user_name') }}@else{{ $data->user_name }}@endif">
				</div>

				<div class="form-group">
					<label for="password">password</label>
					<input type="text" class="form-control" name="password" value="@if(old('password')){{ old('password') }}@else{{ $data->password }}@endif">
				</div>

				<button type="submit" class="btn btn-primary">Save setting</button>
			</form>
		</div>
	</div>
      </div>
</div>
@stop