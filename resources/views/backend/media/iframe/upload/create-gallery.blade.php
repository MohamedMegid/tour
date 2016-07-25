@extends('backend.media.iframe.master')
@section('content')
<h2 class="sub-header">{{ trans('backend.upload_new_image') }}</h2>
    <form action="{{ action('MediaController@store_image_gallery') }}" method="POST" role="form" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="form-group">
          <label for="">{{ trans('backend.image') }}</label>
          <input type="file" name="image">
          <p>{{ trans('backend.max_size') }} : 1 MB</p>
          <p>{{ trans('backend.supported_extantions') }} :jpg jpeg png gif</p>
      </div>
      <button type="submit" class="btn btn-primary">{{ trans('backend.upload') }}</button>
    </form>
@endsection