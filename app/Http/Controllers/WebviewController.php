<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Site;
use App\News;
use App\City;
use App\Area;
use App\GmapEvent;
use App\Events;
use App\Setting;
use Lang;
use Auth;
use App\Visit;

class WebviewController extends Controller
{
    public function sites($id)
    {
    	$current_site = Site::with('site_section')
                    ->with('author')->with('image')->with('gallery.media')->with('visits')->where('published', '=', '1')->leftJoin('sites_trans as trans', 'sites.id', '=', 'trans.site_id')
                    ->select('sites.*', 'trans.lang', 'trans.title', 'trans.summary', 'trans.description', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->where('sites.id', '=', $id)
                    ->with(['comments' => function ($query)
                    {
                        $query->where('published', '=', '1')
                                ->where('lang', '=', Lang::getlocale())
                                ->where('content_type', '<', '3') // 1 and 2
                                ->with('author');
                    }])
                    ->with('reviews');
        if($current_site->count()) {
        $get_from = '1'; //web
        if(Auth::user()){
           $get_user_id = Auth::user()->id;  
        }else{
            $get_user_id ='';
        }
        //check if registerd user or visitor = null
        if($get_user_id){
          $user_id = $get_user_id;
        }
        else{
          $user_id = null;
        }
        //end check if registerd user or visitor
        //start visit
        $old_visit = Visit::where('content_id', '=', $id)->where('content_type', '=', '1')->where('user_id', '=', $user_id)->first();
        if($old_visit) {
            $visit = Visit::find($old_visit->id);
            $visit->content_type = '1';// for sites
            $visit->content_id = $id;
            $visit->user_id = $user_id;
            if($get_from == '1'){
                $visit->web_visits = $old_visit->web_visits +1;
            }elseif($get_from == '2'){
                $visit->ios_visits = $old_visit->ios_visits +1;
            }elseif ($get_from == '3') {
                $visit->android_visits  = $old_visit->android_visits +1;
            }
            $visit->total_visits = $old_visit->total_visits +1;
            $visit->lang = Lang::getlocale();
            $visit->save();
        }else{
            $visit = New Visit;
            $visit->content_type = '1';// for sites
            $visit->content_id = $id;
            $visit->user_id = $user_id;
            if($get_from == '1'){
               $visit->web_visits = '1';
            }elseif($get_from == '2'){
               $visit->ios_visits = '1';
            }elseif ($get_from == '3') {
               $visit->android_visits  = '1';
            }
            $visit->total_visits = '1';
            $visit->lang = Lang::getlocale();
            $visit->save();
        }
        $site = $current_site->first();
        // end visit
        $result = $site;
    }
         
        return view('api-webview.view.site', compact('site'));
    }

    public function news($id)
    {
    	$current_news = News::with('image')->with('visits')->where('published', '=', '1')->leftJoin('news_trans as trans', 'news.id', '=', 'trans.tid')
                 ->select('news.*', 'trans.lang', 'trans.title', 'trans.summary', 'trans.body', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->where('news.id', '=', $id);
    	
        if($current_news->count()) {
            //check if registerd user or visitor = null
            $get_from = '1'; //web
            if(Auth::user()){
               $get_user_id = Auth::user()->id;  
            }else{
                $get_user_id ='';
            }
            //check if registerd user or visitor = null
            if($get_user_id){
              $user_id = $get_user_id;
            }
            else{
              $user_id = null;
            }
            //end check if registerd user or visitor
            //start visit
            $old_visit = Visit::where('content_id', '=', $id)->where('content_type', '=', '2')->where('user_id', '=', $user_id)->first();
            if($old_visit) {
                $visit = Visit::find($old_visit->id);
                $visit->content_type = '2';// for sites
                $visit->content_id = $id;
                $visit->user_id = $user_id;
                if($get_from == '1'){
                    $visit->web_visits = $old_visit->web_visits +1;
                }elseif($get_from == '2'){
                    $visit->ios_visits = $old_visit->ios_visits +1;
                }elseif ($get_from == '3') {
                    $visit->android_visits  = $old_visit->android_visits +1;
                }
                $visit->total_visits = $old_visit->total_visits +1;
                $visit->lang = Lang::getlocale();
                $visit->save();
            }else{
                $visit = New Visit;
                $visit->content_type = '2';// for sites
                $visit->content_id = $id;
                $visit->user_id = $user_id;
                if($get_from == '1'){
                   $visit->web_visits = '1';
                }elseif($get_from == '2'){
                   $visit->ios_visits = '1';
                }elseif ($get_from == '3') {
                   $visit->android_visits  = '1';
                }
                $visit->total_visits = '1';
                $visit->lang = Lang::getlocale();
                $visit->save();
            }
            $news = $current_news->first();
            $result = $news;
        }
    	return view('api-webview.view.news', compact('news'));
    }

    public function app_links()
    {
    	$setting = Setting::find(3);
        $app_links = json_decode($setting->options);
        return $app_links;
    }

    public function events_wv($id)
    {
        $current_events = Events::leftJoin('events_trans as trans', 'events.id', '=', 'trans.tid')->leftJoin('gmap_event as map', 'events.id', '=', 'map.event_id')
             ->select('events.*', 'trans.*', 'map.*')->where('trans.lang', '=', Lang::getlocale())->where('events.id', '=', $id);

        if($current_events->count()) {
            //check if registerd user or visitor = null
            $get_from = '1'; //web
            if(Auth::user()){
               $get_user_id = Auth::user()->id;  
            }else{
                $get_user_id ='';
            }
            //check if registerd user or visitor = null
            if($get_user_id){
              $user_id = $get_user_id;
            }
            else{
              $user_id = null;
            }
            //end check if registerd user or visitor
            //start visit
            $old_visit = Visit::where('content_id', '=', $id)->where('content_type', '=', '4')->where('user_id', '=', $user_id)->first();
            if($old_visit) {
                $visit = Visit::find($old_visit->id);
                $visit->content_type = '4';// for events
                $visit->content_id = $id;
                $visit->user_id = $user_id;
                if($get_from == '1'){
                    $visit->web_visits = $old_visit->web_visits +1;
                }elseif($get_from == '2'){
                    $visit->ios_visits = $old_visit->ios_visits +1;
                }elseif ($get_from == '3') {
                    $visit->android_visits  = $old_visit->android_visits +1;
                }
                $visit->total_visits = $old_visit->total_visits +1;
                $visit->lang = Lang::getlocale();
                $visit->save();
            }else{
                $visit = New Visit;
                $visit->content_type = '4';// for sites
                $visit->content_id = $id;
                $visit->user_id = $user_id;
                if($get_from == '1'){
                   $visit->web_visits = '1';
                }elseif($get_from == '2'){
                   $visit->ios_visits = '1';
                }elseif ($get_from == '3') {
                   $visit->android_visits  = '1';
                }
                $visit->total_visits = '1';
                $visit->lang = Lang::getlocale();
                $visit->save();
            }
            $events = $current_events->first();
            $result = $events;
        }
        $cities = City::leftJoin('city_trans as trans', 'city.id', '=', 'trans.tid')
             ->select('city.*', 'trans.lang', 'trans.name', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->get();
        $areas = Area::leftJoin('area_trans as trans', 'area.id', '=', 'trans.tid')
             ->select('area.*', 'trans.lang', 'trans.name', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->get();
        $map = GmapEvent::where('event_id', '=', $id)->first();
        return view('api-webview.view.events', compact('events', 'cities', 'areas', 'map'));
    }
}
