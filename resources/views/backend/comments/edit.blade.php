@inject('Language', 'App\Http\Controllers\LanguageController') 
@extends('backend.master')
@section('header')
<!--media-->
<link href="{{ asset('assets/backend/vendors/modal/css/component.css') }}" rel="stylesheet" />
@endsection
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="list" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.edit') }} {{ trans('backend.comment') }}</h1>
    <ol class="breadcrumb">
      <li><a href="/{{ Lang::getlocale() }}/admin"> {{ trans('backend.dashboard') }}</a></li>
      <li><a href="/{{ Lang::getlocale() }}/admin/comments"> {{ trans('backend.list_comments') }}</a></li>
      <li class="active"> {{ trans('backend.edit') }} {{ trans('backend.comment') }}</li>
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
                <h3 class="panel-title"><i class="livicon" data-name="list" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>{{ trans('backend.edit') }} {{ trans('backend.comment') }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ action('CommentsController@update', $comment->id) }}" method="POST" role="form">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-md-9">
                            <div class="form-group">
                                <label for="comment">{{ trans('backend.comment') }}</label>
                                <textarea name="comment" id="input" class="form-control" rows="7">@if($comment->comment){{ $comment->comment }}@else{{ old('comment') }}@endif</textarea>
                            </div>
                            </div>
                            <div class="col-md-3 sidbare">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label><input name="published" type="checkbox" value="1" class="minimal-blue" @if($comment->published == '1' || old('published') == 1) checked @endif> {{ trans('backend.published') }}</label>
                                    </div>
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