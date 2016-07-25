@extends('backend.master')

@section('content-header')
<section class="content-header">
                <h1><i class="livicon" data-name="flag" data-size="30" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>
                إدارة الصالات</h1>
              <ol class="breadcrumb">
                    <li><a href="/admin"><i class="fa fa-tachometer"></i> لوحة التحكم</a></li>
                    <li><a href="/admin/users"><i class="fa fa-users"></i> إستعراض المستخدمين</a></li>
                    <li class="active"><i class="fa fa-trash"></i> تأكيد حذف مستخدمين</li>
                </ol>   
</section>
@endsection

@section('content')
<div class="row">
            <div class="col-md-12">
                         <div class="panel panel-primary">
                                	<div class="panel-heading">
                                           	<h3 class="panel-title"><i class="livicon" data-name="user-add" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i> حذف مستخدمين </h3>
                                       </div>

                    	             <div class="panel-body">
                                                    <div class="alert alert-warning">
                                                        هل أنت متأكد ان ترييد حذف <strong>المستخدمين التاليين ؟</strong>
                                                    </div>
                                                    {!! Form::open(['action' => ['UsersController@bulkdestroy'], 'method' =>'post']) !!}
                                                    @foreach($users as $user)
                                                            <h2>{{$user->name}}</h2>
                                                            {!! Form::hidden('user_ids[]', $user->id) !!}
                                                    @endforeach 
                                                    {!! Form::submit('حذف', array('class'=>'btn btn-danger')) !!}
                                                   <a class="btn btn-primary" href="{{action('UsersController@index')}}">إلغاء</a>
                                                   {!! Form::close()!!}
                                      </div>
                          </div>
            </div>                     
</div>
@endsection
@stop