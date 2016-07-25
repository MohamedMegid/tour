<!-- fullwidth modal-->
<div class="modal fade in" id="download" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="livicon" data-name="download" data-size="18" data-c="#F89A14" data-hc="#5CB85C" data-loop="true"></i> {{ trans('backend.download_app') }}</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center;">
                    @if(!empty($Webview->app_links()->apple))
                    <a href="{{ $Webview->app_links()->apple }}"><img src="{{ asset('assets/img/apple.png') }}"></a>
                    @endif
                    
                    @if(!empty($Webview->app_links()->google))
                    <a href="{{ $Webview->app_links()->google }}"><img src="{{ asset('assets/img/google.png') }}"></a>
                    @endif
                </p>
            </div>
            
        </div>
    </div>
</div>
<!-- END modal-->