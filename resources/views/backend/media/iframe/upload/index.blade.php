@extends('backend.media.iframe.master')
@section('header')
<style type="text/css">
	.selected .img-responsive{
		border: 2px solid #418BCA !important;
        box-shadow: 3px 3px 3px 3px #A6CFF2;
	}
</style>
@endsection
@section('content')
<input type="hidden" id="return-id" value="">
<input type="hidden" id="return-url" value="">
@foreach ($images as $image)
<div class="col-xs-6 col-sm-3 placeholder image-item">
  <a id="{{$image->id}}" data-url="/{{$image->thumbnail}}" class="" onclick="returnFileUrl(this)"><img src="/{{$image->thumbnail}}" class="img-responsive"></a>
</div>
@endforeach

@endsection
@section('paginate')
<div class="pagination"> {!! $images->render() !!} </div>
@endsection
@section('footer')
<script>
    // Simulate user action of selecting a file to be returned to CKEditor.
    function returnFileUrl(obj) {
        //remove any other selected if only one value needed
        $("a").removeClass("selected");
        // add selected class to obj
        $(obj).addClass("selected");

        // change value and set last selected-- data id
        var fileID = obj.getAttribute("id");
        $('#return-id').val(fileID);

        // data url
        var fileurl = obj.getAttribute("data-url");
        $('#return-url').val(fileurl);
    }
</script>
@endsection