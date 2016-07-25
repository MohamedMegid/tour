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
                      <label for="">{{ trans('backend.name') }}</label>
                      <input type="text" class="form-control" id="" name="name" value="@if (!empty($_GET['name'])){{$_GET['name']}}@endif" placeholder="{{ trans('backend.name') }}">
                    </div>

                    <div class="form-group">
                      <label for="">{{ trans('backend.phone') }}</label>
                      <input type="text" class="form-control" id="" name="phone" value="@if (!empty($_GET['phone'])){{$_GET['phone']}}@endif" placeholder="{{ trans('backend.phone') }}">
                    </div>

                    <div class="form-group">
                      <label for="">{{ trans('backend.mail') }}</label>
                      <input type="text" class="form-control" id="" name="mail" value="@if (!empty($_GET['mail'])){{$_GET['mail']}}@endif" placeholder="{{ trans('backend.mail') }}">
                    </div>

                    <div class="form-group">
                      <label for="">{{ trans('backend.section') }}</label>
                      <select name="complain_section_id" class="form-control">
                        <option value="">- {{ trans('backend.select') }} -</option>
                        @if ($complain_sections->count())
                          @foreach ($complain_sections as $sec)
                            <option value="{{$sec->id}}" @if (!empty($_GET['complain_section_id'])) @if ($_GET['complain_section_id'] == $sec->id) selected @endif @endif>{{$sec->title}}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ trans('backend.filter') }}</button>
            </form>
          </div>
        </div>
      </div>
  </div>
</div>