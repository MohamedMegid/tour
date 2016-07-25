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
                      <label for="">{{ trans('backend.section') }}</label>
                      <select name="complain_section_id" class="form-control">
                        <option value="">- {{ trans('backend.select') }} -</option>
                        @if ($complain_sections->count())
                          @foreach ($complain_sections as $sec){{$sec->title}}
                            <option value="{{$sec->id}}" @if (!empty($_GET['complain_section_id'])) @if ($_GET['complain_section_id'] == $sec->id) selected @endif @endif>{{$sec->title}}</option>
                          @endforeach
                        @endif
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

                    <button type="submit" class="btn btn-primary">{{ trans('backend.filter') }}</button>
            </form>
          </div>
        </div>
      </div>
  </div>
</div>