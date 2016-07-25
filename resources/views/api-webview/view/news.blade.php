@extends('api-webview.view.master')
@section('header')

@endsection
@section('content')
	@if($news)
	<div class="row">
	    <div class="col-sm-12 col-md-12 col-full-width-right">
	    	@if($news->image)
	        <div class="blog-detail-image" style="background: #000;">
	            <img src="/{{ $news->image->file }}" class="img-responsive" alt="Image" style="margin: 0 auto; max-height: 450px;">
	        </div>
	        @endif
	        <!-- /.blog-detail-image -->
	        <div class="the-box no-border blog-detail-content">
	        	<h1>{{$news->title}}</h1>
	            <p>
	                <span class="label label-danger square">{{date('Y-m-d', strtotime($news->created_at))}}</span>
	            </p>
	            <p class="text-justify">
	                {!!$news->body!!}
	            </p>
	            <br /><br /><br />
	        </div>
	        <!-- /the.box .no-border -->
	    </div>
	</div>
	@else
	<h1 style="text-align: center;">{{ trans('backend.bakend.page_not_found') }}</h2>
	@endif
@endsection
@section('footer')

@endsection