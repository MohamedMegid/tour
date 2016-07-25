@extends('backend.master')
@section('header')
<!--piker for time filter -->
<link href="{{ asset('assets/backend/vendors/timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/backend/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen" />
<!--end piker for time filter -->
<!--choosen -->
<link rel="stylesheet" href="{{ asset('assets/backend/custom/chosen/chosen.css')}}">
<!--end choosen -->
@endsection
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="list" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.manage_reviews') }}</h1>
    <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard') }}</a></li>
            <li class="active"> {{ trans('backend.list_reviews') }}</li>
    </ol>   
</section>
@endsection

@section('content')
<!-- Include filter -->
@include('backend.reviews.filter')
<!-- end include filter -->  

<!-- Include single delete confirmation model -->
@include('backend.reviews.confirm-delete')
<!-- end include single delete confirmation model -->  

<!-- Include bulk delete confirmation model -->
@include('backend.reviews.bulk-confirm-delete')
<!-- end include bulk delete confirmation model -->  

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="livicon" data-name="responsive" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                         {{ trans('backend.list_reviews') }}
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                     @if ($reviews->count())
                     <form method="POST" id="bulk">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-bordered table-striped table-bordered">
                        <thead class="flip-content">
                            <tr>
                                <th>
                                    <input type="checkbox" name="check_all" id="checkall">
                                </th>
                                <th>{{ trans('backend.code') }}</th>
                                <th>
                                    {{ trans('backend.reviews') }}
                                </th>
                                <th>
                                    <span class="pull-left field-name">{{ trans('backend.type') }}</span>
                                    <span class="pull-right sort">	
                                    	<?php
                                    		$url = $_SERVER['REQUEST_URI'];
                                    	?>
                                    	@if(isset($_GET['type']))
                                        @else
                                        @endif
                                    </span>
                                </th>
                                <th>
                                    {{ trans('backend.content') }}
                                </th>
                                <th>
                                    <span class="pull-left field-name">{{ trans('backend.created_at') }}</span>
                                    <span class="pull-right sort">	
                                    </span>
                                </th>
                                <th>
                                    <span class="pull-left field-name">{{ trans('backend.last_update') }}</span>
                                    <span class="pull-right sort">	
                                    </span>
                                </th>
                                <th>{{ trans('backend.operations') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($reviews as $item)
                            <tr>
                                       <td>
                                                <input type="checkbox" name="ids[]" class="check_list" value="{{$item->id}}">
                                          </td>
                                        <td>{{$item->id}}</td>
                                        <td>
                                        	<?php
                                                $limit = 20;
                                                $review = $item->review;
                                                if (strlen($review) > $limit)
                                                    $review = substr($review, 0, strrpos(substr($review, 0, $limit), ' ')) . '...';
                                            ?>
                                        	{{$review}}
                                        </td>
                                        <td>

                                        @if ($item->content_type == 1)
                                          {{ trans('backend.tourism_services') }}
                                        @elseif ($item->content_type == 2)
                                          {{ trans('backend.tourism_sites') }}
                                        @endif
                                        </td>
                                        <td>{{ $item->content_id }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                          <a onclick="confirmDelete(this)" data-toggle="modal" data-href="#full-width" data-id="{{ $item->id }}" data-review="{{ $item->review }}" href="#full-width"><i class="fa fa-trash-o"></i> {{ trans('backend.delete') }}</a>
                                    </tr>
                        @endforeach
                        @else
                        <div class="text-center">
                            @if(isset($_GET['name']))
                            <h1>{{ trans('backend.no_results_found') }}
                             <a href="/{{Lang::getlocale()}}/admin/reviews">{{ trans('backend.back') }}</a></h1>
                            @elseif(Request::is(''.Lang::getlocale().'/admin/reviews'))
                            <h1>{{ trans('backend.no_data_added_before') }}
                            </h1>
                            @endif
                         </div>
                        @endif
                    @if($reviews->count())
                        </tbody>
                    </table>
                    <div class="form-group bulk">
                        <a class="btn btn-danger btn-large" onclick="bulkconfirmDelete()"><span class="glyphicon glyphicon-trash"></span> {{ trans('backend.bulk_delete') }}</a>
                    </div>
                   </form>
                   <div class="table-footer">
                         <div class="count"> <i class="fa fa-folder-o"></i> {{ trans('backend.total') }} : {{ $reviews->total() }} {{ trans('backend.reviews') }} </div>
                        <div class="pagination-area"> {!! $reviews->render() !!} </div>
                    </div>
                @endif
                </div>
            </div>
	    </div>
</div>
@endsection
@section('footer')
<!--Model -->
<script src="{{ asset('assets/backend/vendors/modal/js/classie.js') }}"></script>
<script src="{{ asset('assets/backend/vendors/modal/js/modalEffects.js') }}"></script>
<!--end model -->

<!--single delete item -->
<script type="text/javascript">
function confirmDelete(item) {
    var id = item.getAttribute("data-id");
    var title = item.getAttribute("data-review");

    $("#confirm-id").val(id);
    document.getElementById("confirm-title").innerHTML = title;
}
</script>
<!--end single delete item -->

<!--bulk items delete -->
<script src="{{ asset('assets/backend/js/bulkselect.js') }}"></script>
<script type="text/javascript">
    function bulkconfirmDelete() {
        var http = new XMLHttpRequest();
        http.open("POST", "{{action('ReviewController@bulk_destroy_confirm')}}", true);
        http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var params = $('input:checkbox.check_list').serialize();
        if(params){
            http.send(params);
            http.onload = function() {
                var bulk_data = document.getElementById("bulk-data");
                $("#bulk-data").empty();
                var data = JSON.parse(http.responseText);
                for (var i=0; i < data.length; i++){
                    var id= data[i].id;
                    var name= data[i].review;
                    
                    bulk_data.innerHTML += "<input type='hidden' name='ids[]' value='"+id+"'><p class="+i+"><b>"+name+"</b></p>";
                }
                // open model after post action
                $('#Bulk-confirm').modal({
                     show: true
                });
            }
        }
        else{
            var messages = document.getElementById("messages");
            $("#messages").empty();
            messages.innerHTML = "<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>{{trans('backend.nothing_selected')}}</div>";
        }
    }
</script>
<!--end bulk items delete -->

<!-- Any other bulk actions and need to submit the form -->
<script>
    function submitForm(action)
    {
        document.getElementById('bulk').action = action;
        document.getElementById('bulk').submit();
    }
</script>
<!--end other bulk actions -->

<!--datetime picker for time filter-->
<script src="{{ asset('assets/backend/vendors/timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/vendors/datetimepicker/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('assets/backend/vendors/datetimepicker/js/locales/bootstrap-datetimepicker.fr.js') }}" charset="UTF-8"></script>
<script src="{{ asset('assets/backend/js/pages/pickers.js') }}"></script>
<!--end datetime picker for time filter-->

<!-- choosen -->
<script src="{{ asset('assets/backend/custom/chosen/chosen.jquery.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
</script>
<!-- end choosen -->
@endsection