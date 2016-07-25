<div class="form-group">
        <a data-toggle="modal" data-href="#full-width-gallery" href="#full-width-gallery" id="gallery-thumbnails" class="btn btn-block btn-primary"><span class="glyphicon glyphicon-picture"></span> {{ trans('backend.select_images') }}</a>
</div>
<div id="gallery">
	@if(isset($gallery))
		@foreach($gallery as $image)
			<div class='gallery-img'><img src='/{{ $image->media->thumbnail }}' /><a href='#gallery' class='img-delete'>x</a><input type='hidden' name='gallery_images[]' value='{{ $image->media_id }}'></div>
		@endforeach
	@endif
</div>