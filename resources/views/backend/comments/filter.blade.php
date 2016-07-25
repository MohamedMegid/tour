<div class="row">
  <div class="col-md-12">
    <div class="panel panel-success  panel-filter">
       <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-search"></span> {{ trans('backend.filter') }}</h3>
           <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
       </div>
      <div class="panel-body" style="display: block;">
          <div class="box-body">
             <form method="GET" class="filter" action="">
                    <div class="form-group">
                      <label for="">{{ trans('backend.comment') }}</label>
                      <input type="text" class="form-control" id="" name="comment" value="@if (!empty($_GET['comment'])){{$_GET['comment']}}@endif" placeholder="{{ trans('backend.comment') }}">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('backend.type') }}</label>
                         <select name="type" class="form-control">
                           <option value="">- {{ trans('backend.select') }} -</option>
                           <option value="1" @if(!empty($_GET['type']) && $_GET['type'] == '1') selected @endif>{{ trans('backend.tourism_services') }}</option>
                           <option value="2" @if(!empty($_GET['type']) && $_GET['type'] == '2') selected @endif>{{ trans('backend.tourism_sites') }}</option>
                         </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('backend.created_at') }}</label>
                         <div class="input-group date form_datetime-1" data-date="{{ date('Y-m-d') }}" data-date-format="dd mm yyyy" data-link-field="dtp_input1">
                           <input size="16" type="text" value="@if (!empty($_GET['created_at'])){{$_GET['created_at']}}@endif" readonly class="form-control" name="created_at">
                           <span class="input-group-addon">
                           <span class="glyphicon glyphicon-th"></span>
                           </span>
                        </div>
                    </div>
                      
                    <div class="form-group">
                        <label>{{ trans('backend.last_update') }}</label>
                         <div class="input-group date form_datetime-1" data-date="{{ date('Y-m-d') }}" data-date-format="dd mm yyyy" data-link-field="dtp_input1">
                           <input size="16" type="text" value="@if (!empty($_GET['last_update'])){{$_GET['last_update']}}@endif" readonly class="form-control" name="last_update">
                           <span class="input-group-addon">
                           <span class="glyphicon glyphicon-th"></span>
                           </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{ trans('backend.status') }}</label>
                         <select name="published" class="form-control">
                           <option value="">- {{ trans('backend.select') }} -</option>
                           <option value="1" @if(!empty($_GET['published']) && $_GET['published'] == '1') selected @endif>{{ trans('backend.published') }}</option>
                           <option value="2" @if(!empty($_GET['published']) && $_GET['published'] == '2') selected @endif>{{ trans('backend.unpublished') }}</option>
                         </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">{{ trans('backend.filter') }}</button>
            </form>
          </div>
        </div>
      </div>
  </div>
</div>