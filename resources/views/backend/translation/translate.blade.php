@extends('backend.master')

@section('content-header')
<section class="content-header">
                <h1><i class="livicon" data-name="flag" data-size="30" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>
                </h1>
              <ol class="breadcrumb">
                    <li><a href="/admin"><i class="fa fa-tachometer"></i> لوحة التحكم</a></li>
                    <li class="active"><i class="fa fa-flag-o"></i> إستعراض اللغات</li>
                </ol>   
</section>
@endsection

@section('content')
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
<div class="box-body">
                                            {!! Form::open(['action' => 'TranslationController@storetranslation', 'method' =>'post']) !!}
                                                    <div class="form-inline">
                                                        {!! Form::hidden('word_id', $word_id) !!}
                                                        {!! Form::hidden('lang_id', $lang_id) !!}
                                                         <p> الكلمة المفتاحية: {{$word->word}} </p>
                                                            <p> 
                                                                @if ($translation_lang)
                                                                الترجمة الحالية:  {{$translation_lang->translation}}
                                                                @endif
                                                            </p>
                                                        <div class="form-group">
                                                           
                                                                     {!! Form::text('word', null,['class'=>'form-control', 'placeholder'=>'الترجمة'])!!}
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
</div>
@endsection
@section('footer')

@endsection
@stop