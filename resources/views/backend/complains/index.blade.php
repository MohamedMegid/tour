@inject('Language', 'App\Http\Controllers\LanguageController') 
@extends('backend.master')
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="phone" data-size="30" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>
      {{ trans('backend.Complains')}}</h1>
    <ol class="breadcrumb">
          <li><a href="/{{Lang::getlocale()}}/admin"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard')}}</a></li>
          <li class="active"><i class="fa fa-flag-o"></i> {{ trans('backend.List Complains')}}</li>
    </ol>   
</section>
@endsection

@section('content')
<!-- Include filter -->
@include('backend.complains.filter')
<!-- end include filter -->  

<!-- Include single delete confirmation model -->
@include('backend.complains.confirm-delete')
<!-- end include single delete confirmation model -->  

<!-- Include bulk delete confirmation model -->
@include('backend.complains.bulk-confirm-delete')
<!-- end include bulk delete confirmation model --> 
<div class="row">
    <div class="col-md-12">
      <!-- BEGIN SAMPLE TABLE PORTLET-->
      <div class="portlet box primary">
                  <div class="portlet-title">
                      <div class="caption">
                        <i class="livicon" data-name="responsive" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                         {{ trans('backend.List Complains')}}
                      </div>
                   </div>

                   <div class="portlet-body">
                          <div class="table-responsive">
                                @if ($complains->count())
                                <form id="bulk" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                 <table class="table table-bordered">
                                    <thead class="flip-content">
                                        <tr>
                                          <th><input type="checkbox" name="check_all" id="checkall"></th>
                                          <th>{{ trans('backend.from')}}</th>
                                          <th>{{ trans('backend.phone')}}</th>
                                          <th>{{ trans('backend.email')}}</th>
                                          <th>{{ trans('backend.message_subject')}}</th>
                                          <th>{{ trans('backend.section')}}</th>
                                          <th>{{ trans('backend.receive_date')}}</th>
                                          <th>{{ trans('backend.status')}}</th>
                                          <th>{{ trans('backend.operations')}}</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      @foreach($complains as $contact)
                                        <tr>
                                          <td><input type="checkbox" name="ids[]" class="check_list" value="{{$contact->id}}"></td>
                                          <td> {{ $contact->name }} </td>
                                          <td> {{ $contact->mobile }} </td>
                                          <td> {{ $contact->mail }} </td>
                                          <td>{{ strip_tags(str_limit($contact->message, $limit = 30, $end = '...')) }} </td>
                                          <td>
                                           @if($contact->section)
                                              @if($contact->section->trans)
                                              {{ $contact->section->trans->title }}
                                              @endif
                                           @endif
                                           </td>
                                          <td> {{ $contact->created_at }} </td>
                                          <td>
                                          @if($contact->reply_status == '2')
                                              {{ trans('backend.not_replied')}} 
                                          @elseif($contact->reply_status == '1')
                                            {{ trans('backend.replied')}} 
                                          @endif
                                          </td>
                                          <td>
                                              <a href="{{ action('ComplainController@show', $contact->id) }}"><i class="fa fa-eye"></i> {{ trans('backend.Complain details')}}</a>
                                              @if($contact->reply_status == '2')
                                              <a href="{{ action('ComplainController@reply', $contact->id) }}"><i class="fa fa-reply"></i> {{ trans('backend.reply')}}</a>
                                              @endif
                                              <a onclick="confirmDelete(this)" data-toggle="modal" data-href="#full-width" data-id="{{ $contact->id }}" data-title="{{ $contact->message }}" href="#full-width"><i class="fa fa-trash-o"></i> {{ trans('backend.delete') }}</a>
                                          </td>
                                        </tr>
                                      @endforeach
                                      </tbody>
                                </table>
                                  <div class="form-group bulk">
                                      <a class="btn btn-danger btn-large" onclick="bulkconfirmDelete()"><span class="glyphicon glyphicon-trash"></span> {{ trans('backend.bulk_delete') }}</a>
                                      <!--
                                      <a class="btn btn-success btn-large" onclick="submitForm('{{action('NewsController@bulk_status', ['1'])}}')"><span class="glyphicon glyphicon-ok"></span> {{ trans('backend.bulk_publish') }}</a>

                                      <a class="btn btn-warning btn-large" onclick="submitForm('{{action('NewsController@bulk_status', ['2'])}}')"><span class="glyphicon glyphicon-ban-circle"></span> {{ trans('backend.bulk_unpublish') }}</a>
                                      -->
                                  </div>
                                </form>
                                @else
                                  <div class="text-center"><h1>{{ trans('backend.no_results')}}</h1> </div>
                                @endif
                                 <div class="count"> <i class="fa fa-folder-o"></i> {{ trans('backend.total')}} : {{ $complains->total() }} {{ trans('backend.complain')}} </div>
                                 <div class="pagination-area"> {!! $complains->render() !!} </div>
                        </div>         
                  </div>
      </div>
      
    </div>
</div>
@endsection

@section('footer')
<!--Model -->
<script src="{{ asset('assets/backend/js/bulkselect.js') }}"></script>

<script src="{{ asset('assets/backend/vendors/modal/js/classie.js') }}"></script>
<script src="{{ asset('assets/backend/vendors/modal/js/modalEffects.js') }}"></script>
<!--end model -->

<!--single delete item -->
<script type="text/javascript">
function confirmDelete(item) {
    var id = item.getAttribute("data-id");
    var title = item.getAttribute("data-title");

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
        http.open("POST", "{{action('ComplainController@bulk_destroy_confirm')}}", true);
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
                    var name= data[i].message;
                    
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