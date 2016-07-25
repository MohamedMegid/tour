<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ImpLinksRequest;

use App\ImpLinks;
use App\ImpLinksTrans;
use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;

class ImpLinksController extends Controller
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

        $list = ImpLinks::leftJoin('implinks_trans as trans', 'implink.id', '=', 'trans.tid')
             ->select('implink.*', 'trans.lang', 'trans.title', 'trans.link', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());

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

        return view('backend.implinks.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.implinks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImpLinksRequest $request)
    {
        $items = new ImpLinks;
        $items->main_image_id = $request->main_image_id;
        $items->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $link = 'link';
                $trans = new ImpLinksTrans;
                
                $trans->title = $request->$title;
                $trans->link = $request->$link;

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

        return redirect(''.$Currentlanguage.'/admin/implinks');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $items = ImpLinks::find($id);
        $trans = ImpLinksTrans::where('tid', '=', $id)->get()->keyBy('lang')->toArray();
        $media = Media::where('id', '=', $items->main_image_id)->first();
        $link = ImpLinksTrans::where('tid', '=', $id)->first(['link']);
        return view('backend.implinks.edit', compact('items', 'media', 'trans', 'link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImpLinksRequest $request, $id)
    {
        $items = ImpLinks::find($id);
        $items->main_image_id = $request->main_image_id;
        $items->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $link = 'link';
                
                $trans = ImpLinksTrans::where('tid', '=', $items->id)->where('lang', '=', $language)->first();
                if(empty($trans)){
                    $trans = new ImpLinksTrans;
                }
                
                $trans->title = $request->$title;
                $trans->link = $request->$link;

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
        return redirect(''.$Currentlanguage.'/admin/implinks');
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
                $trans = ImpLinksTrans::where('lang', '=', $language)->where('tid', '=', $id)->first();
                if($trans) {
                    $trans->delete();
                }
            }
            $check_items_trans =  ImpLinksTrans::where('tid', '=', $id)->first();
            if(!$check_items_trans){
                $items = ImpLinks::find($id);
                if (!empty($items)){
                    $items->delete();
                }
            }
        }

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/implinks');
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
        $items = ImpLinksTrans::whereIn('tid', $request->ids)->where('lang', '=', Lang::getlocale())->get();
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
        $items = ImpLinks::find($request->ids);

        foreach ($items as $item) {
            //languages
            $languages = Language::all();
            if($languages->count()){
                foreach ($request->language as $language) {
                    $trans = ImpLinksTrans::where('lang', '=', $language)->where('tid', '=', $item->id)->first();

                    if($trans) {
                        $trans->delete();
                    }
                }
                $check_items_trans =  ImpLinksTrans::where('tid', '=', $item->id)->first();
                if(!$check_items_trans){
                    $item->delete();
                }
            }
            // end languages
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/implinks');
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
