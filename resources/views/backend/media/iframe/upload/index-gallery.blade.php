@extends('backend.media.iframe.master')
@section('header')
<style type="text/css">
	.selected .img-responsive{
		border: 2px solid #418BCA !important;
        box-shadow: 3px 3px 3px 3px #A6CFF2;
	}
</style>
<link href="{{ asset('assets/media/image-picker/image-picker.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('assets/backend/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ asset('assets/media/image-picker/image-picker.js') }}"></script>
@endsection
@section('content')
<input type="hidden" id="json-data" value="">
<div id="ids"></div>
@foreach ($images as $image)
<div class="col-xs-6 col-sm-3 placeholder image-item">
  <a id="{{$image->id}}" data-url="/{{$image->thumbnail}}" class="" onclick="isKeyPressed(this)"><img src="/{{$image->thumbnail}}" class="img-responsive"></a>
</div>
@endforeach


@endsection
@section('paginate')
<div class="pagination"> {!! $images->render() !!} </div>
@endsection
@section('footer')

<script>
function isKeyPressed(obj) {
    if($(obj).hasClass('selected')){
        $(obj).removeClass("selected");
        // get data from obj
        var fileID = obj.getAttribute("id");
        // remove clicked input
        var group = document.getElementById("ids");
        var image = document.getElementById(""+fileID+"");
        group.removeChild(image);

        // get all inputs and set data to json in another hidden input 
        var inputs = document.querySelectorAll("#ids input[name='ids[]']");
        var json = [];
        for (i = 0; i < inputs.length; i++) {
            var url = inputs[i].getAttribute("value");
            var id = inputs[i].getAttribute("id");
            var data = {id:""+id+"",url:""+url+""};
            json.push(data);
        }
        $('#json-data').val(JSON.stringify(json));
        //end collectiong json and setting it to another hidden input
    }
    else{
        $(obj).addClass("selected");
        // get data from obj
        var fileID = obj.getAttribute("id");
        var fileurl = obj.getAttribute("data-url");
        // set data to hidden inputs
        var ids = document.getElementById("ids");
        ids.innerHTML += "<input type='hidden' id='"+fileID+"' class='images-ids' name='ids[]' value='"+fileurl+"'>";
        // get all inputs and set data to json in another hidden input 
        var inputs = document.querySelectorAll("#ids input[name='ids[]']");
        var json = [];
        for (i = 0; i < inputs.length; i++) {
            var url = inputs[i].getAttribute("value");
            var id = inputs[i].getAttribute("id");
            var data = {id:""+id+"",url:""+url+""};
            json.push(data);
        }
        $('#json-data').val(JSON.stringify(json));
        //end collectiong json and setting it to another hidden input
    }
}
</script>

@endsection