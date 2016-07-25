<!-- fullwidth modal-->
<div class="modal fade in" id="Bulk-confirm" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="livicon" data-name="trash" data-size="18" data-c="#F89A14" data-hc="#5CB85C" data-loop="true"></i> {{ trans('backend.bulk_delete_confirmation') }}</h4>
            </div>
            <form action="{{ action('NewsController@bulk_destroy') }}" method="POST" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <p>{{ trans('backend.confirm_delete_msg') }} {{ trans('backend.the_following') }} ?</p>  
                    <div id="bulk-data"></div>
                    @if($Language->all()->count())
                        <div class="form-group">
                            <label>{{ trans('backend.select_languages_you_need_to_delete') }}</label>
                            @foreach($Language->all() as $key => $lang)
                            <div class="checkbox">
                                <label for="checkboxes-0">
                                  <input type="checkbox" name="language[{{$key}}]" value="{{$lang->code}}"@if(Lang::getlocale() == $lang->code) checked @endif>
                                  {{$lang->name}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">{{ trans('backend.delete') }}</button>
                    <button type="button" data-dismiss="modal" class="btn">{{ trans('backend.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END modal-->