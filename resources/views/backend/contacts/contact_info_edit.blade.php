@extends('backend.master')
@section('content-header')
<!-- Main content -->
<section class="content-header">
    <h1><i class="livicon" data-name="list" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.edit') }} {{ trans('backend.contacts_info') }}</h1>
    <ol class="breadcrumb">
      <li><a href="/{{ Lang::getlocale() }}/admin"> {{ trans('backend.dashboard') }}</a></li>
      <li><a href="/{{ Lang::getlocale() }}/admin/contacts"> {{ trans('backend.list_contacts') }}</a></li>
      <li class="active"> {{ trans('backend.edit') }} {{ trans('backend.contacts_info') }}</li>
    </ol>   
</section>
</ol>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
         <div class="panel panel-primary" id="hidepanel1">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                    {{ trans('backend.contacts_info') }}
                                </h3>
                            </div>
                            @if (empty($contact))
                                <h3 class="panel-body">يجب اضافة معلومات التواصل اولا للقيام بعملية التعديل, للاضافة <a href="/admin/contact-us/cont-info">صفحة الاضافة</a></h3>
                            @else
                                <div class="panel-body">
                                    <form action="{{ action('ContactsController@update_contact_info', $contact->id) }}" method="POST" role="form">
                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <label for="title">{{ trans('backend.title') }}</label>
                                            <input type="text" class="form-control" name="title" value="{{$contact->title}}">
                                        </div>

                                        <div class="form-group">
                                          <label>{{ trans('backend.mail') }}</label>
                                          <input type="text" class="form-control" name="mail" value="{{$contact->mail}}">
                                        </div>

                                        <div class="form-group">
                                            <label>{{ trans('backend.phone_numbers') }}</label>
                                            <div id="main">
                                                @if ($phones->count())
                                                    @foreach ($phones as $phone)
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                    
                                                        <input type='text' value="{{$phone->phone}}" name="phone{{ $phone->counter }}" class="form-control"/><br>
                                                        </div>
                                                        <div class="col-md-2">
                                                        <input type="button" class="close_more_videos" value="X">
                                                    </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <input type="button" id="abc" value="Add more" style="background-color: #326488;color: #eee;"/>
                                            <input type='text' name='counter' id="counter" value="{{$phones->count()}}" />
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block btn-primary">{{ trans('backend.update') }}</button>
                                        </div>
                                    </form>
                                </div>
                            @endif
        </div>
    </div>
</div>
@endsection
@section('footer')
<script type="text/javascript">
    var count = $('#counter').val();
    var i = ++count;
    $("#abc").click(function() {
        var input = "<div class='row'>"+
                        "<div class='col-md-10'>"+
                            "<input type='text' name='phone"+i+"' class='form-control'/>"+
                        "</div>"+
                        "<div class='col-md-2'>"+
                            "<input type='button' class='close_more_videos' value='X'>"+
                        "</div>"+
                    "</div><br>";
        $("#main").append(input);
        i++;
    });
    $("#abc").click(function() {
        var counter = document.getElementById('main').getElementsByTagName('input').length;
        $('#counter').val(counter);
    });
    $(document).on('click','.close_more_videos',function(){
                $(this).parent().prev().children().hide();
                $(this).parent().prev().children().val('');
                $(this).hide();
            });
</script>
@endsection

@section('header')
<style type="text/css">
    #counter{
        display: none !important;
    }
    input.close_more_videos{
        display: inline-block;
        box-sizing: content-box;
        float: left;
        z-index: auto;
        width: 20px;
        height: 22px;
        position: relative;
        cursor: default;
        opacity: 1;
        margin-right: 5px;
        padding: 0px;
        overflow: visible;
        border: medium none;
        border-radius: 1em;
        color: #fff;
        text-overflow: clip;
        background: #485567 none repeat scroll 0% 0%;
        box-shadow: none;
        text-shadow: none;
        transition: none 0s ease 0s;
        transform: none;
        transform-origin: 50% 50% 0px;
        padding: 2px;
    }
</style>
@endsection