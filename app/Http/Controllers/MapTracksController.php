<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\MapTracksRequest;

use App\MapTracks;
use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;

class MapTracksController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $map = MapTracks::first();
        $Currentlanguage = Lang::getLocale();
        return view('backend.maptracks.create', compact('map', 'Currentlanguage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MapTracksRequest $request)
    {
        $map = new MapTracks;
        $map->main_image_id = $request->main_image_id;
        $map->save();

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }

        return redirect(''.$Currentlanguage.'/admin/maptracks/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $media = '';
        $map = MapTracks::first();
        if (!empty($map)){
            $media = Media::where('id', '=', $map->main_image_id)->first();
        }
        $Currentlanguage = Lang::getLocale();
        return view('backend.maptracks.edit', compact('map', 'media', 'Currentlanguage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MapTracksRequest $request)
    {
        $map = MapTracks::first();
        $map->main_image_id = $request->main_image_id;
        $map->update();

        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/maptracks/edit');
    }
}
