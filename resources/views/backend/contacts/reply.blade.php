@extends('backend.master')
@section('header')
 <link href="{{ asset('assets/backend/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" />
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.1.0.css') }}" />
@endsection
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="phone" data-size="30" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>
        {{ trans('backend.contact_messages')}}</h1>
    <ol class="breadcrumb">
        <li><a href="/{{Lang::getlocale()}}/admin"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard')}}</a></li>
        <li><a href="/{{Lang::getlocale()}}/admin/contacts"> {{ trans('backend.list_messages')}}</a></li>
        <li class="active"> {{ trans('backend.message_reply')}}</li>
    </ol>   
</section>
@endsection

@section('content')
<div class="row">
     <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                        <h3 class="panel-title"><i class="livicon" data-name="phone" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>{{ trans('backend.message_reply')}}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-scrollable">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td><b>{{ trans('backend.from')}}:</b></td>
                                        <td>{{ $message->name }}</td>
                                    </tr>
                                    @if($message->user_id > '0')
                                    <tr>
                                        <td><b>{{ trans('backend.from_user')}}:</b></td>
                                        <td>{{ $message->user->name }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td><b>{{ trans('backend.message_subject')}}:</b></td>
                                        <td>{{ $message->subject }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ trans('backend.phone')}}:</b></td>
                                        <td>{{ $message->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ trans('backend.email')}}:</b></td>
                                        <td>{{ $message->mail }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ trans('backend.message')}}:</b></td>
                                        <td>{{ $message->message}} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <form action="{{ action('ContactsController@store_reply', $message->id) }}" method="POST" role="form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="reply_message">{{ trans('backend.message_reply')}}</label>
                                <textarea name="reply_message" id="input" class="form-control" rows="10">{{ old('reply_message') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ trans('backend.send')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection