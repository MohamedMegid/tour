<div class="row">
  <div class="col-md-12">
    <div class="panel panel-success  panel-filter">
       <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-search"></span> {{ trans('backend.filter') }}</h3>
           <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
       </div>
      <div class="panel-body" style="display: block;">
          <div class="box-body">
             <form action="" method="GET" class="filter">
                    <div class="form-group">
                      <label for="">{{ trans('backend.section_name') }}</label>
                      <input type="text" class="form-control" id="" name="name" value="@if (!empty($_GET['name'])){{$_GET['name']}}@endif" placeholder="{{ trans('backend.section') }}">
                    </div>

                    <div class="form-group">
                      <label for="" style="display:block;">{{ trans('backend.author') }}</label>
                      <select  data-placeholder="{{ trans('backend.author') }}" class="chosen-select" tabindex="2" style="min-width: 204px;" name="created_by">
                        <option value=""></option>
                        @foreach($authors as $author)
                          @if($author->author)
                          <option value="{{ $author->created_by }}" @if(!empty($_GET['created_by']) && $author->created_by == $_GET['created_by']) selected @endif>{{ $author->author->name }}</option>
                         @endif
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="" style="display:block;">{{ trans('backend.updated_by') }}</label>
                      <select  data-placeholder="{{ trans('backend.updated_by') }}" class="chosen-select" tabindex="2" style="min-width: 204px;" name="updated_by">
                        <option value=""></option>
                        @foreach($editors as $editor)
                          @if($editor->last_updated_by)
                          <option value="{{ $editor->updated_by }}" @if(!empty($_GET['updated_by']) && $editor->updated_by == $_GET['updated_by']) selected @endif>{{ $editor->last_updated_by->name }}</option>
                         @endif
                        @endforeach
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