<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Http\Requests\PhotoAlbumRequest;

use App\PhotoAlbum;
use App\PhotoAlbumTrans;
use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;
use MediaLibrary;

class PhotoAlbumController extends Controller
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

        $list = PhotoAlbum::leftJoin('photoablum_trans as trans', 'photoalbum.id', '=', 'trans.tid')
             ->select('photoalbum.*', 'trans.lang', 'trans.title', 'trans.summary', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());

        if(!empty($_GET['title'])){
            $title = $_GET['title'];
            $list->where('trans.title', 'like', '%'.$title.'%');     
        }
        if(!empty($_GET['created_at'])){
            $created_at = $_GET['created_at'];
            $list->where('trans.created_at', '>=', ''.$created_at.' 00:00:00')->where('trans.created_at', '<=', ''.$created_at.' 23:59:59');           
        }
        if(!empty($_GET['last_update'])){
            $last_update = $_GET['last_update'];
            $list->where('trans.updated_at', '>=', ''.$last_update.' 00:00:00')->where('trans.updated_at', '<=', ''.$last_update.' 23:59:59');           
        }
        if(!empty($_GET['orderby']) && !empty($_GET['sort'])){
            $orderby = $_GET['orderby'];
            $sort = $_GET['sort'];
            $list->orderBy($orderby, $sort);           
        }
        
        $items = $list->paginate(10);
        // add to pagination other fields
        $items->appends(['title' => $title, 'created_at' => $created_at,
         'last_update' => $last_update, 'orderby' => $orderby, 'sort' => $sort]);

        return view('backend.palbum.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.palbum.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhotoAlbumRequest $request)
    {
        $items = new PhotoAlbum;
        $items->main_image_id = $request->main_image_id;
        $items->save();

        // Gallery
        $media = new MediaLibrary;
        $content_type = '2';//2 for sites
        $content_id = $items->id;
        $category_id = null;
        $is_main = '0';
        $image_order = '0';
        if($request->gallery_images){
            foreach ($request->gallery_images as $media_id) {
                $media->store_to_gallery($media_id, $content_type, $content_id, $category_id, $is_main, $image_order);
            }
        }
        // End Gallery

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $summary = 'summary_'.$language.'';
                $trans = new PhotoAlbumTrans;
                
                $trans->title = $request->$title;
                $trans->summary = $request->$summary;

                $trans->lang = $language;
                $trans->tid = $items->id;
                
                $trans->save();
            }
        }
        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }

        return redirect(''.$Currentlanguage.'/admin/palbum');
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
        $items = PhotoAlbum::find($id);
        $trans = PhotoAlbumTrans::where('tid', '=', $id)->get()->keyBy('lang')->toArray();
        $media = Media::where('id', '=', $items->main_image_id)->first();

        //gallery
        $content_type = '2';
        $content_id = $id;
        $category_id = null;
        $is_main = '0';
        $gallery = new MediaLibrary;
        $gallery = $gallery->select_from_gallery($content_type, $content_id, $category_id, $is_main);
        //end gallery

        return view('backend.palbum.edit', compact('items', 'media', 'trans', 'gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PhotoAlbumRequest $request, $id)
    {
        $items = PhotoAlbum::find($id);
        $items->main_image_id = $request->main_image_id;
        $items->save();

        // Gallery
        $media = new MediaLibrary;
        $content_type = '2';//2 for photo album
        $content_id = $items->id;
        $category_id = null;
        $is_main = '0';
        $image_order = '0';
        if($request->gallery_images){
            //delete old images
            $media->delete_from_gallery($content_type, $content_id, $category_id, $is_main);
            //end delete old images
            foreach ($request->gallery_images as $media_id) {
                $media->store_to_gallery($media_id, $content_type, $content_id, $category_id, $is_main, $image_order);
            }
        }
        // End Gallery

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $summary = 'summary_'.$language.'';
                
                $trans = PhotoAlbumTrans::where('tid', '=', $items->id)->where('lang', '=', $language)->first();
                if(empty($trans)){
                    $trans = new PhotoAlbumTrans;
                }
                
                $trans->title = $request->$title;
                $trans->summary = $request->$summary;

                $trans->lang = $language;
                $trans->tid = $items->id;
                
                $trans->save();
            }
        }

        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/palbum');
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
                $trans = PhotoAlbumTrans::where('lang', '=', $language)->where('tid', '=', $id)->first();
                if($trans) {
                    $trans->delete();
                }
            }
            $check_items_trans =  PhotoAlbumTrans::where('tid', '=', $id)->first();
            if(!$check_items_trans){
                $palbum = PhotoAlbum::find($id);
                if (!empty($palbum)){
                    $palbum->delete();
                }
            }
        }

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/palbum');
    }

    /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $items = PhotoAlbumTrans::whereIn('tid', $request->ids)->where('lang', '=', Lang::getlocale())->get();
        return $items;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $items = PhotoAlbum::find($request->ids);

        foreach ($items as $item) {
            //languages
            $languages = Language::all();
            if($languages->count()){
                foreach ($request->language as $language) {
                    $trans = PhotoAlbumTrans::where('lang', '=', $language)->where('tid', '=', $item->id)->first();

                    if($trans) {
                        $trans->delete();
                    }
                }
                $check_items_trans =  PhotoAlbumTrans::where('tid', '=', $item->id)->first();
                if(!$check_items_trans){
                    $item->delete();
                }
            }
            // end languages
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/palbum');
    }
}
