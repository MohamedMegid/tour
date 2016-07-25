@extends('backend.master')

@section('content-header')
<section class="content-header">
                <h1><i class="livicon" data-name="flag" data-size="30" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>
                {{ $page_title->translation}} </h1>
              <ol class="breadcrumb">
                    <li><a href="/admin"><i class="fa fa-tachometer"></i> لوحة التحكم</a></li>
                    <li class="active"><i class="fa fa-flag-o"></i> إستعراض اللغات</li>
                </ol>   
</section>
@endsection

@section('content')
<div class="row">
                             <div class="col-md-12">
                                <!-- Start Filter -->
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                         <h3 class="panel-title">
                                            <span class="glyphicon glyphicon-plus"></span>
                                            إضافة لغة
                                         </h3>
                                         <span class="pull-left clickable panel-collapsed">
                                              <i class="glyphicon glyphicon-chevron-down"></i>
                                        </span>
                                    </div>
                                     <div class="panel-body" style="display: none;">
                                        <div class="box-body">
                                            {!! Form::open(['action' => 'LanguageController@store', 'method' =>'post']) !!}
                                                    <div class="form-inline">
                                                            <div class="form-group">
                                                               {!! Form::text('name', null,['class'=>'form-control', 'placeholder'=>'إسم اللغة'])!!}
                                                             </div>
                                                             <div class="form-group">
                                                              {!! Form::text('code', null,['class'=>'form-control', 'placeholder'=>'كود اللغة'])!!}
                                                              </div>
                                                             <div class="form-group">
                                                                {!! Form::label('direction', 'إتجاه اللغة') !!}
                                                                <select id="direction" name="direction">
                                                                     <option value="0"> من اليسار لليمين</option>
                                                                     <option value="1"> من اليمين لليسار </option>
                                                                 </select>
                                                            </div>
                                                            <div class="form-group">
                                                                  <span class="input-group-btn">
                                                                        {!! Form::submit('حفظ', ['class'=>'btn btn-primary'])!!}
                                                                  </span>
                                                            </div>
                                                    </div>
                                            {!! Form::close()!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!-- End Filter -->
</div>
@if($languages->count())
<div class="row">
                             <div class="col-md-12">
                                <!-- Start Filter -->
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                         <h3 class="panel-title">
                                            <span class="glyphicon glyphicon-plus"></span>
                                            {{$defualt_lang->translation}}
                                         </h3>
                                         <span class="pull-left clickable panel-collapsed">
                                              <i class="glyphicon glyphicon-chevron-down"></i>
                                        </span>
                                    </div>
                                     <div class="panel-body" style="display: none;">
                                        <div class="box-body">
                                            {!! Form::open(['action' => 'LanguageController@update', 'method' =>'patch']) !!}
                                                    <div class="form-inline">
                                                             <div class="form-group">
                                                                {!! Form::label('main', ''.$defualt_lang->translation.'') !!}
                                                                <select id="main" name="main">
                                                                  <option value=""> -اختر-</option>
                                                                  @foreach ($languages as $language)
                                                                     <option value="{{$language->id}}" @if($language->main == '1') selected @endif> {{$language->name}}</option>
                                                                  @endforeach
                                                                 </select>
                                                            </div>
                                                            <div class="form-group">
                                                                  <span class="input-group-btn">
                                                                        {!! Form::submit('حفظ', ['class'=>'btn btn-primary'])!!}
                                                                  </span>
                                                            </div>
                                                    </div>
                                            {!! Form::close()!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!-- End Filter -->
</div>
@endif

<div class="row">
    <div class="col-md-12">
  <!-- BEGIN SAMPLE TABLE PORTLET-->
 <div class="portlet box primary">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="livicon" data-name="responsive" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                    إستعراض الغات
                                </div>
</div>
<div class="portlet-body">
                                <div class="table-responsive">
                                   @if ($languages->count())
                                    {!! Form::open(['method' => 'post', 'action'=> 'LanguageController@bulkdeleteconfirm']) !!}
                                    <table class="table table-bordered">
                                    <thead class="flip-content">
                                        <tr>
                                          <th>
                                                <input type="checkbox" name="check_all" id="checkall">
                                            </th>
                                            <th>كود</th>
                                            <th>إسم اللغة</th>
                                            <th>كود اللغة</th>
                                            <th>تاريخ الإنشاء</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($languages as $language)
                                    <tr>
                                       <td>
                                                <input type="checkbox" name="check_list[{{$language->id}}]" class="check_list" value="{{$language->id}}">
                                        </td>
                                        <td>{{$language->id}}</td>
                                        <td>{{$language->name}}</td>
                                        <td>{{$language->code}}</td>
                                        <td>{{$language->created_at}}</td>
                                        <td>
	                                       <a href="{{action('LanguageController@destroyconfirm', $language->id)}}"><i class="fa fa-trash-o"></i> حذف</a>
                                        </td>
                                        </tr>
                         				@endforeach
                                      @else
                                    <div class="text-center"><h1>عفوا لا يوجد نتائج</h1> </div>
                                    @endif
                                    </tbody>
                                </table>
                                 <div class="form-group">
                                              <input type="submit" name="delete" value="مسح" class="btn btn-primary">
                                 </div>
                                 <div> <i class="fa fa-folder-o"></i> إجمالي : {{ $languages->count() }} لغة </div>
                           </div>
                        	</div>
</div>
    </div>
</div>
@endsection
@section('footer')
    <script src="{{ asset('assets/backend/js/bulkselect.js') }}"></script>
@endsection
@stop