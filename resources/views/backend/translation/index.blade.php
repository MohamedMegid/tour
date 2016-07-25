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
                                            
                                         </h3>
                                         <span class="pull-left clickable panel-collapsed">
                                              <i class="glyphicon glyphicon-chevron-down"></i>
                                        </span>
                                    </div>
                                     <div class="panel-body" style="display: none;">
                                        <div class="box-body">
                                            {!! Form::open(['action' => 'TranslationController@store', 'method' =>'post']) !!}
                                                    <div class="form-inline">
                                                              <div class="form-group">
                                                                     {!! Form::text('word', null,['class'=>'form-control', 'placeholder'=>'لكلمة المفتاحية'])!!}
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
                                   @if ($translations->count())
                                    <table class="table table-bordered">
                                    <thead class="flip-content">
                                        <tr>
                                            <th>كود</th>
                                            <th>الكلمة المفتاحية</th>
                                            <th>تاريخ الإنشاء</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($translations as $word)
                                    <tr>
                                        <td>{{$word->id}}</td>
                                        <td>{{$word->word}}</td>
                                        <td>{{$word->created_at}}</td>
                                        <td>
                                            @if($languages->count())
                                                    @foreach ($languages as $lang)
        	                                    <a href="{{action('TranslationController@translate', [$word->id, $lang->id])}}"><i class="fa fa-flag"></i> {{ $lang->name }}</a>
                                                    @endforeach
                                            @endif
                                        </td>
                                        </tr>
                         		@endforeach
                                      @else
                                    <div class="text-center"><h1>عفوا لا يوجد نتائج</h1> </div>
                                    @endif
                                    </tbody>
                                </table>
                                 <div> <i class="fa fa-folder-o"></i> إجمالي : {{ $translations->count() }} لغة </div>
                           </div>
                        	</div>
</div>
    </div>
</div>
@endsection
@section('footer')

@endsection
@stop