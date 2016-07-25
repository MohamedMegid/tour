@inject('Language', 'App\Http\Controllers\LanguageController') 
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
    <h1><i class="livicon" data-name="list" data-size="25" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>{{ trans('backend.list_sites') }}</h1>
    <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard') }}</a></li>
            <li class="active"> {{ trans('backend.list_sites') }}</li>
    </ol>   
</section>
@endsection

@section('content')
<!-- Include filter -->
@include('backend.sites.filter')
<!-- end include filter -->  

<!-- Include single delete confirmation model -->
@include('backend.sites.confirm-delete')
<!-- end include single delete confirmation model -->  

<!-- Include bulk delete confirmation model -->
@include('backend.sites.bulk-confirm-delete')
<!-- end include bulk delete confirmation model -->  

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box primary">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="livicon" data-name="responsive" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                         {{ trans('backend.list_sites') }}
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                     @if ($sites->count())
                     <form method="POST" id="bulk">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-bordered table-striped table-bordered">
                        <thead class="flip-content">
                            <tr>
                                <th>
                                    <input type="checkbox" name="check_all" id="checkall">
                                </th>
                                <th>{{ trans('backend.image') }}</th>
                                <th>
                                    <span class="pull-left field-name">{{ trans('backend.title') }}</span>
                                    <span class="pull-right sort">
                                        @if(isset($_GET['title']))
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Asc' && isset($_GET['orderby']) && $_GET['orderby'] == 'title') class="active" @endif href="{{url(''.Lang::getlocale().'/admin/sites/'.$type.'?title='.$_GET['title'].'&created_by='.$_GET['created_by'].'&updated_by='.$_GET['updated_by'].'&created_at='.$_GET['created_at'].'&last_update='.$_GET['last_update'].'&published='.$_GET['published'].'&orderby=title&sort=Asc&page='.isset($_GET['page']).'')}}"><i class="fa fa-sort-asc"></i></a>
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Desc' && isset($_GET['orderby']) && $_GET['orderby'] == 'title') class="active" @endif href="{{url(''.Lang::getlocale().'/admin/sites/'.$type.'?title='.$_GET['title'].'&created_by='.$_GET['created_by'].'&updated_by='.$_GET['updated_by'].'&created_at='.$_GET['created_at'].'&last_update='.$_GET['last_update'].'&published='.$_GET['published'].'&orderby=title&sort=Desc&page='.isset($_GET['page']).'')}}"><i class="fa fa-sort-desc"></i></a>
                                        @else
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Asc' && isset($_GET['orderby']) && $_GET['orderby'] == 'title') class="active" @endif href="?orderby=title&sort=Asc"><i class="fa fa-sort-asc"></i></a>
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Desc' && isset($_GET['orderby']) && $_GET['orderby'] == 'title') class="active" @endif href="?orderby=title&sort=Desc"><i class="fa fa-sort-desc"></i></a>
                                        @endif
                                    </span>
                                </th>
                                <th>
                                    <span class="pull-left field-name">{{ trans('backend.author') }}</span>
                                    <span class="pull-right sort">
                                        @if(isset($_GET['created_by']))
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Asc' && isset($_GET['orderby']) && $_GET['orderby'] == 'created_by') class="active" @endif href="{{url(''.Lang::getlocale().'/admin/sites/'.$type.'?title='.$_GET['title'].'&created_by='.$_GET['created_by'].'&updated_by='.$_GET['updated_by'].'&created_at='.$_GET['created_at'].'&last_update='.$_GET['last_update'].'&published='.$_GET['published'].'&orderby=created_by&sort=Asc&page='.isset($_GET['page']).'')}}"><i class="fa fa-sort-asc"></i></a>
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Desc' && isset($_GET['orderby']) && $_GET['orderby'] == 'created_by') class="active" @endif href="{{url(''.Lang::getlocale().'/admin/sites/'.$type.'?title='.$_GET['title'].'&created_by='.$_GET['created_by'].'&updated_by='.$_GET['updated_by'].'&created_at='.$_GET['created_at'].'&last_update='.$_GET['last_update'].'&published='.$_GET['published'].'&orderby=created_by&sort=Desc&page='.isset($_GET['page']).'')}}"><i class="fa fa-sort-desc"></i></a>
                                        @else
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Asc' && isset($_GET['orderby']) && $_GET['orderby'] == 'created_by') class="active" @endif href="?orderby=created_by&sort=Asc"><i class="fa fa-sort-asc"></i></a>
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Desc' && isset($_GET['orderby']) && $_GET['orderby'] == 'created_by') class="active" @endif href="?orderby=created_by&sort=Desc"><i class="fa fa-sort-desc"></i></a>
                                        @endif
                                    </span>
                                </th>
                                <th>
                                    <span class="pull-left field-name">{{ trans('backend.updated_by') }}</span>
                                    <span class="pull-right sort">
                                        @if(isset($_GET['updated_by']))
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Asc' && isset($_GET['orderby']) && $_GET['orderby'] == 'updated_by') class="active" @endif href="{{url(''.Lang::getlocale().'/admin/sites/'.$type.'?title='.$_GET['title'].'&created_by='.$_GET['created_by'].'&updated_by='.$_GET['updated_by'].'&created_at='.$_GET['created_at'].'&last_update='.$_GET['last_update'].'&published='.$_GET['published'].'&orderby=updated_by&sort=Asc&page='.isset($_GET['page']).'')}}"><i class="fa fa-sort-asc"></i></a>
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Desc' && isset($_GET['orderby']) && $_GET['orderby'] == 'updated_by') class="active" @endif href="{{url(''.Lang::getlocale().'/admin/sites/'.$type.'?title='.$_GET['title'].'&created_by='.$_GET['created_by'].'&updated_by='.$_GET['updated_by'].'&created_at='.$_GET['created_at'].'&last_update='.$_GET['last_update'].'&published='.$_GET['published'].'&orderby=updated_by&sort=Desc&page='.isset($_GET['page']).'')}}"><i class="fa fa-sort-desc"></i></a>
                                        @else
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Asc' && isset($_GET['orderby']) && $_GET['orderby'] == 'updated_by') class="active" @endif href="?orderby=updated_by&sort=Asc"><i class="fa fa-sort-asc"></i></a>
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Desc' && isset($_GET['orderby']) && $_GET['orderby'] == 'updated_by') class="active" @endif href="?orderby=updated_by&sort=Desc"><i class="fa fa-sort-desc"></i></a>
                                        @endif
                                    </span>
                                </th>
                                <th>
                                    <span class="pull-left field-name">{{ trans('backend.created_at') }}</span>
                                    <span class="pull-right sort">
                                        @if(isset($_GET['created_at']))
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Asc' && isset($_GET['orderby']) && $_GET['orderby'] == 'created_at') class="active" @endif href="{{url(''.Lang::getlocale().'/admin/sites/'.$type.'?title='.$_GET['title'].'&created_by='.$_GET['created_by'].'&updated_by='.$_GET['updated_by'].'&created_at='.$_GET['created_at'].'&last_update='.$_GET['last_update'].'&published='.$_GET['published'].'&orderby=created_at&sort=Asc&page='.isset($_GET['page']).'')}}"><i class="fa fa-sort-asc"></i></a>
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Desc' && isset($_GET['orderby']) && $_GET['orderby'] == 'created_at') class="active" @endif href="{{url(''.Lang::getlocale().'/admin/sites/'.$type.'?title='.$_GET['title'].'&created_by='.$_GET['created_by'].'&updated_by='.$_GET['updated_by'].'&created_at='.$_GET['created_at'].'&last_update='.$_GET['last_update'].'&published='.$_GET['published'].'&orderby=created_at&sort=Desc&page='.isset($_GET['page']).'')}}"><i class="fa fa-sort-desc"></i></a>
                                        @else
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Asc' && isset($_GET['orderby']) && $_GET['orderby'] == 'created_at') class="active" @endif href="?orderby=created_at&sort=Asc"><i class="fa fa-sort-asc"></i></a>
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Desc' && isset($_GET['orderby']) && $_GET['orderby'] == 'created_at') class="active" @endif href="?orderby=created_at&sort=Desc"><i class="fa fa-sort-desc"></i></a>
                                        @endif
                                    </span>
                                </th>
                                <th>
                                    <span class="pull-left field-name">{{ trans('backend.last_update') }}</span>
                                    <span class="pull-right sort">
                                        @if(isset($_GET['updated_at']))
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Asc' && isset($_GET['orderby']) && $_GET['orderby'] == 'updated_at') class="active" @endif href="{{url(''.Lang::getlocale().'/admin/sites/'.$type.'?title='.$_GET['title'].'&created_by='.$_GET['created_by'].'&updated_by='.$_GET['updated_by'].'&created_at='.$_GET['created_at'].'&last_update='.$_GET['last_update'].'&published='.$_GET['published'].'&orderby=updated_at&sort=Asc&page='.isset($_GET['page']).'')}}"><i class="fa fa-sort-asc"></i></a>
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Desc' && isset($_GET['orderby']) && $_GET['orderby'] == 'updated_at') class="active" @endif href="{{url(''.Lang::getlocale().'/admin/sites/'.$type.'?title='.$_GET['title'].'&created_by='.$_GET['created_by'].'&updated_by='.$_GET['updated_by'].'&created_at='.$_GET['created_at'].'&last_update='.$_GET['last_update'].'&published='.$_GET['published'].'&orderby=updated_at&sort=Desc&page='.isset($_GET['page']).'')}}"><i class="fa fa-sort-desc"></i></a>
                                        @else
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Asc' && isset($_GET['orderby']) && $_GET['orderby'] == 'updated_at') class="active" @endif href="?orderby=updated_at&sort=Asc"><i class="fa fa-sort-asc"></i></a>
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Desc' && isset($_GET['orderby']) && $_GET['orderby'] == 'updated_at') class="active" @endif href="?orderby=updated_at&sort=Desc"><i class="fa fa-sort-desc"></i></a>
                                        @endif
                                    </span>
                                </th>
                                <th>
                                    <span class="pull-left field-name">{{ trans('backend.status') }}</span>
                                    <span class="pull-right sort">
                                        @if(isset($_GET['published']))
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Asc' && isset($_GET['orderby']) && $_GET['orderby'] == 'published') class="active" @endif href="{{url(''.Lang::getlocale().'/admin/sites/'.$type.'?title='.$_GET['title'].'&created_by='.$_GET['created_by'].'&updated_by='.$_GET['updated_by'].'&created_at='.$_GET['created_at'].'&last_update='.$_GET['last_update'].'&published='.$_GET['published'].'&orderby=published&sort=Asc&page='.isset($_GET['page']).'')}}"><i class="fa fa-sort-asc"></i></a>
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Desc' && isset($_GET['orderby']) && $_GET['orderby'] == 'published') class="active" @endif href="{{url(''.Lang::getlocale().'/admin/sites/'.$type.'?title='.$_GET['title'].'&created_by='.$_GET['created_by'].'&updated_by='.$_GET['updated_by'].'&created_at='.$_GET['created_at'].'&last_update='.$_GET['last_update'].'&published='.$_GET['published'].'&orderby=published&sort=Desc&page='.isset($_GET['page']).'')}}"><i class="fa fa-sort-desc"></i></a>
                                        @else
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Asc' && isset($_GET['orderby']) && $_GET['orderby'] == 'published') class="active" @endif href="?orderby=published&sort=Asc"><i class="fa fa-sort-asc"></i></a>
                                        <a @if(isset($_GET['sort']) && $_GET['sort'] == 'Desc' && isset($_GET['orderby']) && $_GET['orderby'] == 'published') class="active" @endif href="?orderby=published&sort=Desc"><i class="fa fa-sort-desc"></i></a>
                                        @endif
                                    </span>
                                </th>
                                <th>
                                    <span class="pull-left field-name">{{ trans('backend.section') }}</span>
                                </th>
                                <th>{{ trans('backend.reviews') }}</th>
                                <th>{{ trans('backend.operations') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($sites as $site)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" class="check_list" value="{{$site->id}}">
                                </td>
                                <td>
                                    @if($site->image)
                                    <img src="/{{ $site->image->thumbnail }}" width="70">
                                    @else
                                    <img src="{{ asset('assets/img/select_main_img.png') }}" width="70">
                                    @endif
                                </td>
                                <td>
                                 {{ $site->title }}
                                </td>
                                
                                <td>
                                @if($site->author)
                                    {{ $site->author->name }}
                                @endif
                                </td>
                                <td>
                                @if($site->last_updated_by)
                                    {{ $site->last_updated_by->name }}
                                @endif
                                </td>
                                <td>
                                    {{ $site->created_at }}
                                </td>
                                <td>
                                    {{ $site->updated_at }}
                                </td>
                                <td>
                                    @if($site->published == '1')
                                       <a href="{{action('SitesController@single_status', [$type, '2',$site->id])}}" class="label label-sm label-success"><span class="glyphicon glyphicon-ok"></span> {{ trans('backend.published') }}</a>
                                    @elseif($site->published == '2')
                                        <a href="{{action('SitesController@single_status', [$type, '1',$site->id])}}" class="label label-sm label-warning"><span class="glyphicon glyphicon-ban-circle"></span> {{ trans('backend.unpublished') }}</a>
                                    @endif
                                </td>
                                <td>
                                    @foreach ($sections as $section)
                                        @if ($section->id == $site->section_id)
                                           <a href="/{{Lang::getlocale()}}/admin/sections/{{$type}}?name={{$section->name}}&created_by=&updated_by=&created_at=&last_update=&published="> {{ $section->name }}</a>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if($site->reviews->count())
                                        @foreach($site->reviews as $review)
                                            @if($review->average)
                                               <span><i class="fa fa-fw fa-star-half-o"></i> {{ $review->average }}</span>
                                            @endif
                                            <br/>
                                            @if($review->count)
                                                <span><i class="fa fa-users"></i> {{ $review->count }}</span>
                                            @endif
                                        @endforeach
                                    @else
                                        {{trans('backend.nothing')}}
                                    @endif
                                </td>
                                <td class="">
                                <a href="{{action('SitesController@edit', [$type, $site->id])}}"><i class="fa  fa-edit"></i> {{ trans('backend.edit') }}</a>
                                <a onclick="confirmDelete(this)" data-toggle="modal" data-href="#full-width" data-id="{{ $site->id }}" data-title="{{ $site->title }}" href="#full-width"><i class="fa fa-trash-o"></i> {{ trans('backend.delete') }}</a>
                               </td>
                            </tr>
                        @endforeach
                        @else
                        <div class="text-center">
                            @if(isset($_GET['title']))
                            <h1>{{ trans('backend.no_results_found') }}
                             <a href="/{{Lang::getlocale()}}/admin/sites/{{$type}}">{{ trans('backend.back') }}</a></h1>
                            @elseif(Request::is(''.Lang::getlocale().'/admin/sites/'.$type.''))
                            <h1>{{ trans('backend.no_data_added_before') }}
                             <a href="/{{Lang::getlocale()}}/admin/sites/{{$type}}/create">{{ trans('backend.create_content') }}</a></h1>
                            @endif
                         </div>
                        @endif
                    @if($sites->count())
                        </tbody>
                    </table>
                    <div class="form-group bulk">
                        <a class="btn btn-danger btn-large" onclick="bulkconfirmDelete()"><span class="glyphicon glyphicon-trash"></span> {{ trans('backend.bulk_delete') }}</a>

                        <a class="btn btn-success btn-large" onclick="submitForm('{{action('SitesController@bulk_status', [$type, '1'])}}')"><span class="glyphicon glyphicon-ok"></span> {{ trans('backend.bulk_publish') }}</a>

                        <a class="btn btn-warning btn-large" onclick="submitForm('{{action('SitesController@bulk_status', [$type, '2'])}}')"><span class="glyphicon glyphicon-ban-circle"></span> {{ trans('backend.bulk_unpublish') }}</a>
                    </div>
                   </form>
                   <div class="table-footer">
                         <div class="count"> <i class="fa fa-folder-o"></i> {{ trans('backend.total') }} : {{ $sites->total() }} {{ trans('backend.site') }} </div>
                        <div class="pagination-area"> {!! $sites->render() !!} </div>
                    </div>
                @endif
                </div>
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
        http.open("POST", "{{action('SitesController@bulk_destroy_confirm')}}", true);
        http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var params = $('input:checkbox.check_list').serialize();
        if(params){
            http.send(params);
            http.onload = function() {
                var bulk_data = document.getElementById("bulk-data");
                $("#bulk-data").empty();
                var data = JSON.parse(http.responseText);
                for (var i=0; i < data.length; i++){
                    var id= data[i].site_id;
                    var name= data[i].title;
                    
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