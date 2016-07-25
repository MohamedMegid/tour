@inject('Language', 'App\Http\Controllers\LanguageController') 
@extends('backend.master')
@section('header')
<!--media-->
<link href="{{ asset('assets/backend/vendors/modal/css/component.css') }}" rel="stylesheet" />
@endsection
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="user" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.edit') }} {{ trans('backend.user') }}</h1>
    <ol class="breadcrumb">
      <li><a href="/{{ Lang::getlocale() }}/admin"> {{ trans('backend.dashboard') }}</a></li>
      <li><a href="/{{ Lang::getlocale() }}/admin/users"> {{ trans('backend.list_users') }}</a></li>
      <li class="active"> {{ trans('backend.edit') }} {{ trans('backend.user') }}</li>
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
                <h3 class="panel-title"><i class="livicon" data-name="user" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>{{ trans('backend.edit') }} {{ trans('backend.user') }}</h3>
            </div>
            <div class="panel-body">
                <form action="{{ action('UsersController@update', $user->id) }}" method="POST" role="form">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="name">{{ trans('backend.name') }}</label>
                            <input type="text" class="form-control" name="name" value="@if(old('name')){{ old('name') }}@else{{ $user->name }}@endif" placeholder="{{ trans('backend.name') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">{{ trans('backend.email') }}</label>
                            <input type="text" class="form-control" name="email" value="@if(old('email')){{ old('email') }}@else{{ $user->email }}@endif" placeholder="{{ trans('backend.email') }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ trans('backend.phone') }}</label>
                            <input type="text" class="form-control" name="phone" value="@if(old('phone')){{ old('phone') }}@else{{ $user->phone }}@endif" placeholder="{{ trans('backend.phone') }}">
                        </div>
                        <div class="form-group">
                            <label for="password">{{ trans('backend.password') }}</label>
                            <input type="password" class="form-control" name="password" value="" placeholder="{{ trans('backend.password') }}">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{ trans('backend.password_confirmation') }}</label>
                            <input type="password" class="form-control" name="password_confirmation" value="" placeholder="{{ trans('backend.password_confirmation') }}">
                        </div>
                    </div>
                    <div class="col-md-3 sidbare">
                       {{--  <!-- Language field -->
                        @include('backend.language.field')
                        <!-- End Language field --> --}}

                        <!-- Media main image -->
                        @include('backend.media.fields.main-image-field')
                        <!-- End Media main image -->
                        @if($user->id != Auth::user()->id)
                        <!-- User Status -->
                        <div class="form-group">
                            <label>{{ trans('backend.status') }}</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" @if(old('status') == '1') selected @elseif($user->active == '1') selected @endif>{{ trans('backend.active') }}</option>
                                <option value="2" @if(old('status') == '2') selected @elseif($user->active == '2') selected @endif>{{ trans('backend.not_active') }}</option>
                                <option value="3" @if(old('status') == '3') selected @elseif($user->active == '3') selected @endif>{{ trans('backend.blocked') }}</option>
                            </select>
                        </div>
                        <!-- End user Status -->

                        <!-- User Role -->
                        <div class="form-group">
                            <label>{{ trans('backend.role') }}</label>
                            <select name="role" id="role" class="form-control">
                                @foreach($roles as $role)
                                    @if($role->trans)
                                    <option value="{{ $role->id }}" @if(old('role') == $role->id) selected  @elseif($user->user_role)@if($user->user_role->role_id == $role->id) selected @endif @elseif($role->id == '4') selected @endif>
                                    {{ $role->trans->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                            
                        </div>
                        <!-- End user Role -->
                        @endif

                        <div class="form-group">
                            <div class="checkbox">
                                <label><input name="back" type="checkbox" value="1" class="minimal-blue" @if(old('back') == 1) checked @endif> {{ trans('backend.back_after_update') }}</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-primary">{{ trans('backend.update') }}</button>
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