<!-- fullwidth modal-->
<div class="modal fade in" id="full-width" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="livicon" data-name="image" data-size="18" data-c="#F89A14" data-hc="#5CB85C" data-loop="true"></i> {{ trans('backend.media_manager') }}</h4>
            </div>
            <div class="modal-body" style="padding: 0;">
                <iframe id="iframe" src="/{{ Lang::getlocale() }}/media/browse/images" frameborder="0" width="100%" height="400"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn">{{ trans('backend.close') }}</button>
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="set-image">{{ trans('backend.select_image') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- END modal-->