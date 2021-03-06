@inject('Language', 'App\Http\Controllers\LanguageController') 
@extends('backend.master')
@section('header')
<!--media-->
<link href="{{ asset('assets/backend/vendors/modal/css/component.css') }}" rel="stylesheet" />
@endsection
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="list" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.edit') }} {{ trans('backend.photo_album') }}</h1>
    <ol class="breadcrumb">
      <li><a href="/{{ Lang::getlocale() }}/admin"> {{ trans('backend.dashboard') }}</a></li>
      <li><a href="/{{ Lang::getlocale() }}/admin/palbum"> {{ trans('backend.list_photo_albums') }}</a></li>
      <li class="active"> {{ trans('backend.edit') }} {{ trans('backend.photo_album') }}</li>
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
                        <h3 class="panel-title"><i class="livicon" data-name="list" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>{{ trans('backend.edit') }} {{ trans('backend.Photo Album') }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ action('PhotoAlbumController@update', [$items->id]) }}" method="POST" role="form">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-md-9">
                            @if($Language->all()->count())
                                @foreach($Language->all() as $lang)
                                <div id="group-{{$lang->code}}">
                                <div class="form-group">
                                    <label for="title">{{ trans('backend.title') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                    <input type="text" class="form-control" name="title_{{$lang->code}}" value="@if(isset($trans[$lang->code]['title'])){{ $trans[$lang->code]['title'] }}@else{{ old('title_'.$lang->code.'') }}@endif" placeholder="{{ trans('backend.title') }} @if($Language->all()->count() > '1') {{ $lang->name }} @endif">
                                </div>

                                <div class="form-group">
                                    <label for="summary">{{ trans('backend.summary') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                    <textarea name="summary_{{$lang->code}}" id="input" class="form-control" rows="7">@if(isset($trans[$lang->code]['summary'])){{ $trans[$lang->code]['summary'] }}{{ $items->summary }}@else{{ old('summary_'.$lang->code.'') }}@endif</textarea>
                                </div>

                            </div>
                                @endforeach
                            @endif
                            
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
                                @include('backend.language.field')
                                <!-- End Language field -->

                                <!-- Media main image -->
                                @include('backend.media.fields.main-image-field')
                                <!-- End Media main image -->
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