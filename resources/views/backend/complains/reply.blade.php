@extends('backend.master')
@section('header')
<style>
  #map {
    width: 100%;
    height: 400px;
  }
</style>
@endsection
@section('content-header')
<section class="content-header">
    <h1><i class="livicon" data-name="phone" data-size="30" data-c="#418BCA" data-hc="#01BC8C" data-loop="true"></i>
        {{ trans('backend.Complains')}}</h1>
    <ol class="breadcrumb">
        <li><a href="/{{Lang::getlocale()}}/admin"><i class="fa fa-tachometer"></i> {{ trans('backend.dashboard')}}</a></li>
        <li><a href="/{{Lang::getlocale()}}/admin/complains"> {{ trans('backend.List Complains')}}</a></li>
        <li class="active"> {{ trans('backend.message_reply')}}</li>
    </ol>   
</section>
@endsection

@section('content')
<div class="row">
     <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                        <h3 class="panel-title"><i class="livicon" data-name="phone" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>{{ trans('backend.message_reply')}}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-scrollable">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td><b>{{ trans('backend.from')}}:</b></td>
                                        <td>{{ $message->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ trans('backend.message_subject')}}:</b></td>
                                        <td>{{ $message->message }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ trans('backend.phone')}}:</b></td>
                                        <td>{{ $message->mobile }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ trans('backend.email')}}:</b></td>
                                        <td>{{ $message->mail }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ trans('backend.message')}}:</b></td>
                                        <td>{{ $message->message}} </td>
                                    </tr>
                                    @if(!empty($message->photo))
                                    <tr>
                                        <td><b>{{ trans('backend.image')}}:</b></td>
                                        <td>
                                        @if($message->image)
                                            <a href="/{{ $message->image->file}}" target="_blank"><img src="/{{ $message->image->thumbnail}}" /></a>
                                        @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @if(!empty($message->longitude) && !empty($message->latitude))
                                    <tr>
                                        <td><b>{{ trans('backend.location')}}:</b></td>
                                        <td>
                                          <div id="map"></div>
                                        {{-- Location map --}}

                                            <script>
                                            
                                            function initMap() {
                                            var mylat = <?php print $message->latitude; ?>;
                                            var myLng = <?php print $message->longitude; ?>;
                                             if(mylat != '' || mylat != ''){ 
                                                var mylat = <?php print $message->latitude; ?>;
                                                var myLng = <?php print $message->longitude; ?>;

                                            }else{
                                                mylat = 24.966243570682984;
                                                myLng = 46.5293573125;
                                            }
                                            var myLatLng = {lat: mylat, lng: myLng};
                                            var mapDiv = document.getElementById('map');
                                            var map = new google.maps.Map(mapDiv, {
                                              center: {lat: mylat, lng: myLng},
                                              zoom: 8
                                            });
                                            var marker = new google.maps.Marker({
                                            position: myLatLng,
                                            map: map
                                          });
                                        }
                                        </script>
                                        <script src="https://maps.googleapis.com/maps/api/js?callback=initMap"
    async defer></script>
                                        {{-- end Location map --}}  
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                        <form action="{{ action('ComplainController@store_reply', $message->id) }}" method="POST" role="form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="reply_message">{{ trans('backend.message_reply')}}</label>
                                <textarea name="reply_message" id="input" class="form-control" rows="10">{{ old('reply_message') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ trans('backend.send')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection