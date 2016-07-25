<div class="form-group" style="text-align: center;">
    <label for="main_image_id" style="display: block;">{{ trans('backend.main_image') }}</label>
    <input type="hidden" class="form-control" name="main_image_id" id="main-image" value="@if(isset($media)){{ $media->id }}@endif">
    <a class="" data-toggle="modal" data-href="#full-width" href="#full-width" style="max-width: 100%;">
    	@if(isset($media))
		<img id="main-image-thumbnail" src="/{{ $media->thumbnail }}" style="max-width: 100%; border: 2px solid rgb(204, 204, 204);">
    	@else
        <img id="main-image-thumbnail" src="{{ asset('assets/img/select_main_img.png') }}" style="max-width: 100%; border: 2px solid rgb(204, 204, 204);">
        @endif
    </a>
</div>