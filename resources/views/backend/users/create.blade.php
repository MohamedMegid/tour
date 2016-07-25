@inject('Language', 'App\Http\Controllers\LanguageController') 
@extends('backend.master')
@section('header')

@endsection
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="user" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.create') }} {{ trans('backend.user') }}</h1>
    <ol class="breadcrumb">
      <li><a href="/{{ Lang::getlocale() }}/admin"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard') }}</a></li>
      <li><a href="/{{ Lang::getlocale() }}/admin/users"> {{ trans('backend.list_users') }}</a></li>
      <li class="active"> {{ trans('backend.create') }} {{ trans('backend.user') }}</li>
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
               <h3 class="panel-title"><i class="livicon" data-name="user" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> {{ trans('backend.create') }} {{ trans('backend.user') }}</h3>
            </div>
            <div class="panel-body">
                <form action="{{ action('UsersController@store') }}" method="POST" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="name">{{ trans('backend.name') }}</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{ trans('backend.name') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">{{ trans('backend.email') }}</label>
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('backend.email') }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ trans('backend.phone') }}</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="{{ trans('backend.phone') }}">
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
                        {{-- <!-- Language field -->
                        @include('backend.language.field')
                        <!-- End Language field --> --}}

                        <!-- Media main image -->
                        @include('backend.media.fields.main-image-field')
                        <!-- End Media main image -->

                        <!-- User Status -->
                        <div class="form-group">
                            <label>{{ trans('backend.status') }}</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" @if(old('status') == '1') selected @endif>{{ trans('backend.active') }}</option>
                                <option value="2" @if(old('status') == '2') selected @endif>{{ trans('backend.not_active') }}</option>
                                <option value="3" @if(old('status') == '3') selected @endif>{{ trans('backend.blocked') }}</option>
                            </select>
                        </div>
                        <!-- End user Status -->

                        <!-- User Role -->
                        <div class="form-group">
                            <label>{{ trans('backend.role') }}</label>
                            <select name="role" id="role" class="form-control">
                                @foreach($roles as $role)
                                    @if($role->trans && $role->id != 4)
                                    <option value="{{ $role->id }}" @if(old('role') == $role->id) selected @endif>
                                    {{ $role->trans->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                            
                        </div>
                        <!-- End user Role -->

                        <div class="form-group">
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