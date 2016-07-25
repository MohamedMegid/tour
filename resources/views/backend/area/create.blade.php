@inject('Language', 'App\Http\Controllers\LanguageController') 
@extends('backend.master')
@section('header')

@endsection
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="list" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.create') }} {{ trans('backend.area') }}</h1>
    <ol class="breadcrumb">
      <li><a href="/{{ Lang::getlocale() }}/admin"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard') }}</a></li>
      <li><a href="/{{ Lang::getlocale() }}/admin/area"> {{ trans('backend.list_area') }}</a></li>
      <li class="active"> {{ trans('backend.create') }} {{ trans('backend.area') }}</li>
    </ol>   
</section>
@endsection

@section('content')
<div class="row">
     <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
               <h3 class="panel-title"><i class="livicon" data-name="list" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> {{ trans('backend.create') }} {{ trans('backend.area') }}</h3>
            </div>
            <div class="panel-body">
                <form action="{{ action('AreaController@store') }}" method="POST" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-9">
                        @if($Language->all()->count())
                            @foreach($Language->all() as $lang)
                            <div id="group-{{$lang->code}}">
                                <div class="form-group">
                                    <label for="name">{{ trans('backend.name') }} @if($Language->all()->count() > '1') ( {{ $lang->name }} ) @endif</label>
                                    <input type="text" class="form-control" name="name_{{$lang->code}}" value="{{ old('name_'.$lang->code.'') }}" placeholder="{{ trans('backend.name') }} @if($Language->all()->count() > '1') {{ $lang->name }} @endif">
                                </div>

                            </div>
                            @endforeach
                        @endif
                        @if($cities->count())
                            <div class="form-group" id="menu-group">
                                <label for="body">{{ trans('backend.related_city') }}</label>
                                <select name="city" class="form-control">
                                    <option value="">-- {{ trans('backend.select') }} --</option>
                                    @foreach($cities as $city)
                                    <?php
                                        $city_url = '';
                                        if (!empty($_GET['city'])){
                                            $city_url = $_GET['city'];
                                        }
                                    ?>
                                    <option value="{{ $city->id }}" @if(old('city')== $city->id || $city_url == $city->id) selected @endif>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-3 sidbare">
                        <!-- Language field -->
                        @include('backend.language.field')
                        <!-- End Language field -->

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

@endsection