@inject('Language', 'App\Http\Controllers\LanguageController') 
@extends('backend.master')
@section('header')

@endsection
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="list" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.create') }} {{ trans('backend.pages') }}</h1>
    <ol class="breadcrumb">
      <li><a href="/{{ Lang::getlocale() }}/admin"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard') }}</a></li>
      <li><a href="/{{ Lang::getlocale() }}/admin/pages"> {{ trans('backend.list_pages') }}</a></li>
      <li class="active"> {{ trans('backend.create') }} {{ trans('backend.pages') }}</li>
    </ol>   
</section>
@endsection

@section('content')
<div class="row">
     <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
               <h3 class="panel-title"><i class="livicon" data-name="list" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> {{ trans('backend.create') }} {{ trans('backend.pages') }}</h3>
            </div>
            <div class="panel-body">
                <form action="{{ action('PagesController@store') }}" method="POST" role="form">
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
                                    <label for="body">{{ trans('backend.body') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                    <textarea name="body_{{$lang->code}}" id="input" class="form-control" rows="5">{{ old('body_'.$lang->code.'') }}</textarea>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="col-md-3 sidbare">
                        <!-- Language field -->
                        @include('backend.language.field')
                        <!-- End Language field -->

                        <div class="form-group">
                            <div class="checkbox">
                                <label><input name="published" type="checkbox" value="1" class="minimal-blue" @if(old('back') == 1) checked @endif> {{ trans('backend.published') }}</label>
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

@endsection