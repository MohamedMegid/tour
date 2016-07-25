<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\BannersRequest;

use App\Banners;
use App\BannersTrans;
use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;

class BannersController extends Controller
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

        $list_banners = Banners::leftJoin('banners_trans as trans', 'banners.id', '=', 'trans.tid')
             ->select('banners.*', 'trans.lang', 'trans.title', 'trans.link', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());

        if(!empty($_GET['title'])){
            $title = $_GET['title'];
            $list_banners->where('trans.title', 'like', '%'.$title.'%');     
        }
        if(!empty($_GET['created_at'])){
            $created_at = $_GET['created_at'];
            $list_banners->where('trans.created_at', '>=', ''.$created_at.' 00:00:00')->where('trans.created_at', '<=', ''.$created_at.' 23:59:59');           
        }
        if(!empty($_GET['last_update'])){
            $last_update = $_GET['last_update'];
            $list_banners->where('trans.updated_at', '>=', ''.$last_update.' 00:00:00')->where('trans.updated_at', '<=', ''.$last_update.' 23:59:59');           
        }
        if(!empty($_GET['orderby']) && !empty($_GET['sort'])){
            $orderby = $_GET['orderby'];
            $sort = $_GET['sort'];
            $list_banners->orderBy($orderby, $sort);           
        }
        
        $banners = $list_banners->paginate(10);
        // add to pagination other fields
        $banners->appends(['title' => $title, 'created_at' => $created_at,
         'last_update' => $last_update, 'orderby' => $orderby, 'sort' => $sort]);

        return view('backend.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannersRequest $request)
    {
        $banners = new Banners;
        $banners->main_image_id = $request->main_image_id;
        $banners->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $link = 'link';
                $banners_trans = new BannersTrans;
                
                $banners_trans->title = $request->$title;
                $banners_trans->link = $request->$link;

                $banners_trans->lang = $language;
                $banners_trans->tid = $banners->id;
                
                $banners_trans->save();
            }
        }
        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }

        return redirect(''.$Currentlanguage.'/admin/banners');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banners = Banners::find($id);
        $trans = BannersTrans::where('tid', '=', $id)->get()->keyBy('lang')->toArray();
        $media = Media::where('id', '=', $banners->main_image_id)->first();
        $link = BannersTrans::where('tid', '=', $id)->first(['link']);
        return view('backend.banners.edit', compact('banners', 'media', 'trans', 'link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannersRequest $request, $id)
    {
        $banners = Banners::find($id);
        $banners->main_image_id = $request->main_image_id;
        $banners->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $link = 'link';
                
                $banners_trans = BannersTrans::where('tid', '=', $banners->id)->where('lang', '=', $language)->first();
                if(empty($banners_trans)){
                    $banners_trans = new BannersTrans;
                }
                
                $banners_trans->title = $request->$title;
                $banners_trans->link = $request->$link;

                $banners_trans->lang = $language;
                $banners_trans->tid = $banners->id;
                
                $banners_trans->save();
            }
        }

        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/banners');
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
                $banners_trans = BannersTrans::where('lang', '=', $language)->where('tid', '=', $id)->first();
                if($banners_trans) {
                    $banners_trans->delete();
                }
            }
            $check_banners_trans =  BannersTrans::where('tid', '=', $id)->first();
            if(!$check_banners_trans){
                $banners = Banners::find($id);
                if (!empty($banners)){
                    $banners->delete();
                }
            }
        }

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/banners');
    }

    // /**
    //  * Get single status.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
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
        $banners = BannersTrans::whereIn('tid', $request->ids)->where('lang', '=', Lang::getlocale())->get();
        return $banners;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $banners = Banners::find($request->ids);

        foreach ($banners as $item) {
            //languages
            $languages = Language::all();
            if($languages->count()){
                foreach ($request->language as $language) {
                    $banners_trans = BannersTrans::where('lang', '=', $language)->where('tid', '=', $item->id)->first();

                    if($banners_trans) {
                        $banners_trans->delete();
                    }
                }
                $check_banners_trans =  BannersTrans::where('tid', '=', $item->id)->first();
                if(!$check_banners_trans){
                    $item->delete();
                }
            }
            // end languages
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/banners');
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
