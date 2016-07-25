<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\VideoAlbumRequest;

use App\VideoAlbum;
use App\VideoAlbum_trans;
use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;

class VideoAlbumController extends Controller
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

        $list_videos = VideoAlbum::leftJoin('videoalbum_trans as trans', 'videoalbum.id', '=', 'trans.tid')->select('videoalbum.*', 'trans.lang', 'trans.title', 'trans.subject', 'trans.link', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());

        if(!empty($_GET['title'])){
            $title = $_GET['title'];
            $list_videos->where('trans.title', 'like', '%'.$title.'%');     
        }
        if(!empty($_GET['created_at'])){
            $created_at = $_GET['created_at'];
            $list_videos->where('trans.created_at', '>=', ''.$created_at.' 00:00:00')->where('trans.created_at', '<=', ''.$created_at.' 23:59:59');           
        }
        if(!empty($_GET['last_update'])){
            $last_update = $_GET['last_update'];
            $list_videos->where('trans.updated_at', '>=', ''.$last_update.' 00:00:00')->where('trans.updated_at', '<=', ''.$last_update.' 23:59:59');           
        }
        if(!empty($_GET['orderby']) && !empty($_GET['sort'])){
            $orderby = $_GET['orderby'];
            $sort = $_GET['sort'];
            $list_videos->orderBy($orderby, $sort);           
        }
        
        $videos = $list_videos->paginate(10);
        // add to pagination other fields
        $videos->appends(['title' => $title, 'created_at' => $created_at,
         'last_update' => $last_update, 'orderby' => $orderby, 'sort' => $sort]);

        return view('backend.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoAlbumRequest $request)
    {
        $valbum = new VideoAlbum;
        $valbum->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $subject = 'subject_'.$language.'';
                $link = 'link';
                $videos = new VideoAlbum_trans;
                
                $videos->title = $request->$title;
                $videos->subject = $request->$subject;
                $videos->link = $request->$link;
                $videos->lang = $language;
                $videos->tid = $valbum->id;
                
                $videos->save();
            }
        }
        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }

        return redirect(''.$Currentlanguage.'/admin/videos');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $videos = VideoAlbum::find($id);
        $trans = VideoAlbum_trans::where('tid', '=', $id)->get()->keyBy('lang')->toArray();
        $link = VideoAlbum_trans::where('tid', '=', $id)->first(['link']);
        return view('backend.videos.edit', compact('videos', 'trans', 'link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VideoAlbumRequest $request, $id)
    {
        $valbum = VideoAlbum::find($id);
        $valbum->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $subject = 'subject_'.$language.'';
                $link = 'link';
                
                $videos = VideoAlbum_trans::where('tid', '=', $valbum->id)->where('lang', '=', $language)->first();
                if(empty($videos)){
                    $videos = new VideoAlbum_trans;
                }
                
                $videos->title = $request->$title;
                $videos->subject = $request->$subject;
                $videos->link = $request->$link;
                $videos->lang = $language;
                $videos->tid = $valbum->id;
                
                $videos->save();
            }
        }

        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/videos');
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

        //languages
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $videos = VideoAlbum_trans::where('lang', '=', $language)->where('tid', '=', $id)->first();
                if($videos) {
                    $videos->delete();
                }
            }
            $check_v_trans =  VideoAlbum_trans::where('tid', '=', $id)->first();
            if(!$check_v_trans){
                $valbum = VideoAlbum::find($id);
                if (!empty($valbum)){
                    $valbum->delete();
                }
            }
        }

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/videos');
    }

    // /**
    //  * Get single status.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function single_status($status, $id)
    // {
    //     $pages = Pages::find($id);
    //     $pages->published = $status;
    //     $pages->save();

    //     Flash::success(trans('backend.saved_successfully'));
    //     $Currentlanguage = Lang::getLocale();
    //     return redirect(''.$Currentlanguage.'/admin/pages');
    // }

    /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $videos = VideoAlbum_trans::whereIn('tid', $request->ids)->where('lang', '=', Lang::getlocale())->get();
        return $videos;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $valbum = VideoAlbum::find($request->ids);

        foreach ($valbum as $item) {
            //languages
            $languages = Language::all();
            if($languages->count()){
                foreach ($request->language as $language) {
                    $videos = VideoAlbum_trans::where('lang', '=', $language)->where('tid', '=', $item->id)->first();

                    if($videos) {
                        $videos->delete();
                    }
                }
                $check_v_trans =  VideoAlbum_trans::where('tid', '=', $item->id)->first();
                if(!$check_v_trans){
                    $item->delete();
                }
            }
            // end languages
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/videos');
    }

    // /**
    //  * Bulk Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function bulk_status(Request $request,$status)
    // {
    //     $pages = Pages::find($request->ids);
    //     if(!empty($pages)){
    //         foreach ($pages as $item) {
    //             $item->published = $status;
    //             $item->save();
    //         }
    //         Flash::success(trans('backend.saved_successfully'));
    //         $Currentlanguage = Lang::getLocale();
    //         return redirect(''.$Currentlanguage.'/admin/pages');
    //     }
    //     else
    //     {
    //         Flash::warning(trans('backend.nothing_selected'), 'alert-class');           
    //         return back();
    //     }
    // }
}
