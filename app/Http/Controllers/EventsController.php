<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\EventsRequest;
use App\Http\Requests\CityRequest;
use App\Http\Requests\AreaRequest;

use App\Events;
use App\EventsTrans;
use App\City;
use App\CityTrans;
use App\Area;
use App\AreaTrans;
use App\GmapEvent;
use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;

class EventsController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Varibales
        $title = '';
        $created_at = '';
        $last_update = '';
        $orderby = '';
        $sort = '';
        $published = '';

        $list_events = Events::leftJoin('events_trans as trans', 'events.id', '=', 'trans.tid')
             ->select('events.*', 'trans.lang', 'trans.title', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());

        if(!empty($_GET['title'])){
            $title = $_GET['title'];
            $list_events->where('trans.title', 'like', '%'.$title.'%');     
        }
        if(!empty($_GET['created_at'])){
            $created_at = $_GET['created_at'];
            $list_events->where('trans.created_at', '>=', ''.$created_at.' 00:00:00')->where('trans.created_at', '<=', ''.$created_at.' 23:59:59');           
        }
        if(!empty($_GET['last_update'])){
            $last_update = $_GET['last_update'];
            $list_events->where('trans.updated_at', '>=', ''.$last_update.' 00:00:00')->where('trans.updated_at', '<=', ''.$last_update.' 23:59:59');           
        }
        if(!empty($_GET['orderby']) && !empty($_GET['sort'])){
            $orderby = $_GET['orderby'];
            $sort = $_GET['sort'];
            $list_events->orderBy($orderby, $sort);           
        }
        
        $events = $list_events->paginate(10);
        // add to pagination other fields
        $events->appends(['title' => $title, 'created_at' => $created_at,
         'last_update' => $last_update, 'orderby' => $orderby, 'sort' => $sort, 'published' => $published]);

        return view('backend.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $areas = '';//Area::leftJoin('area_trans as trans', 'area.id', '=', 'trans.tid')
             //->select('area.*', 'trans.lang', 'trans.name', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->get();
        $cities = City::leftJoin('city_trans as trans', 'city.id', '=', 'trans.tid')
             ->select('city.*', 'trans.lang', 'trans.name', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->get();


        return view('backend.events.create', compact('cities', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventsRequest $request)
    {
        $events = new Events;
        $events->main_image_id = $request->main_image_id;
        $events->startdate = $request->startdate;
        $events->enddate = $request->enddate;
        $events->from = $request->from;
        $events->to = $request->to;
        $events->city = $request->city;
        $events->area = $request->area;
        $events->website = $request->website;
        if($request->social_published){
            $events->social_published = '1';
        }
        $events->save();

        $gmap = new GmapEvent;
        $gmap->address = $request->input('address');
        $gmap->latitude = $request->input('latitude');
        $gmap->longitude = $request->input('longitude');
        $gmap->event_id = $events->id;
        $gmap->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $details = 'details_'.$language.'';
                $address = 'address_'.$language.'';
                $events_trans = new EventsTrans;
                
                $events_trans->title = $request->$title;
                $events_trans->details = $request->$details;
                $events_trans->address = $request->$address;

                $events_trans->lang = $language;
                $events_trans->tid = $events->id;
                
                $events_trans->save();
            }
        }
        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }

        return redirect(''.$Currentlanguage.'/admin/events');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $events = Events::find($id);
        $trans = EventsTrans::where('tid', '=', $id)->get()->keyBy('lang')->toArray();
        $media = Media::where('id', '=', $events->main_image_id)->first();
        $areas = Area::leftJoin('area_trans as trans', 'area.id', '=', 'trans.tid')
             ->select('area.*', 'trans.lang', 'trans.name', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->where('area.id', '=', $events->area)->get();
        $cities = City::leftJoin('city_trans as trans', 'city.id', '=', 'trans.tid')
             ->select('city.*', 'trans.lang', 'trans.name', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->get();

        $map = GmapEvent::where('event_id', '=', $id)->first();
        return view('backend.events.edit', compact('events', 'media', 'trans', 'areas', 'cities', 'map'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventsRequest $request, $id)
    {
        $events = Events::find($id);
        $events->main_image_id = $request->main_image_id;
        $events->startdate = $request->startdate;
        $events->enddate = $request->enddate;
        $events->from = $request->from;
        $events->to = $request->to;
        $events->city = $request->city;
        $events->area = $request->area;
        $events->website = $request->website;
        if($request->social_published){
            $events->social_published = '1';
        }
        $events->update();

        $gmap = GmapEvent::where('event_id', '=', $id)->first();
        $gmap->address = $request->input('address');
        $gmap->latitude = $request->input('latitude');
        $gmap->longitude = $request->input('longitude');
        $gmap->event_id = $events->id;
        $gmap->update();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $details = 'details_'.$language.'';
                $address = 'address_'.$language.'';
                
                $events_trans = EventsTrans::where('tid', '=', $events->id)->where('lang', '=', $language)->first();
                if(empty($events_trans)){
                    $events_trans = new EventsTrans;
                }
                
                $events_trans->title = $request->$title;
                $events_trans->details = $request->$details;
                $events_trans->address = $request->$address;

                $events_trans->lang = $language;
                $events_trans->tid = $events->id;
                
                $events_trans->update();
            }
        }

        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $map = GmapEvent::where('event_id', '=', $id)->first();
        $map->delete();
        //languages
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $events_trans = EventsTrans::where('lang', '=', $language)->where('tid', '=', $id)->first();
                if($events_trans) {
                    $events_trans->delete();
                }
            }
            $check_events_trans =  EventsTrans::where('tid', '=', $id)->first();
            if(!$check_events_trans){
                $events = Events::find($id);
                if (!empty($events)){
                    $events->delete();
                }
            }
        }

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/events');
    }

    /**
     * Get single status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function single_status($status, $id)
    // {
    //     $news = News::find($id);
    //     $news->published = $status;
    //     $news->save();

    //     Flash::success(trans('backend.saved_successfully'));
    //     $Currentlanguage = Lang::getLocale();
    //     return redirect(''.$Currentlanguage.'/admin/news');
    // }

    /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $events = EventsTrans::whereIn('tid', $request->ids)->where('lang', '=', Lang::getlocale())->get();
        return $events;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $events = Events::find($request->ids);

        foreach ($events as $item) {
            $map = GmapEvent::where('event_id', '=', $item->id)->first();
            $map->delete();
            //languages
            $languages = Language::all();
            if($languages->count()){
                foreach ($request->language as $language) {
                    $events_trans = EventsTrans::where('lang', '=', $language)->where('tid', '=', $item->id)->first();

                    if($events_trans) {
                        $events_trans->delete();
                    }
                }
                $check_events_trans =  EventsTrans::where('tid', '=', $item->id)->first();
                if(!$check_events_trans){
                    $item->delete();
                }
            }
            // end languages
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/events');
    }
    // /**
    //  * Bulk Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function bulk_status(Request $request,$status)
    // {
    //     $news = News::find($request->ids);
    //     if(!empty($news)){
    //         foreach ($news as $item) {
    //             $item->published = $status;
    //             $item->save();
    //         }
    //         Flash::success(trans('backend.saved_successfully'));
    //         $Currentlanguage = Lang::getLocale();
    //         return redirect(''.$Currentlanguage.'/admin/news');
    //     }
    //     else
    //     {
    //         Flash::warning(trans('backend.nothing_selected'), 'alert-class');           
    //         return back();
    //     }
    // }
}
