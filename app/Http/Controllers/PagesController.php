<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\PagesRequest;

use App\Pages;
use App\PagesTrans;
use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;

class PagesController extends Controller
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

        $list_pages = Pages::leftJoin('pages_trans as trans', 'pages.id', '=', 'trans.tid')
             ->select('pages.*', 'trans.lang', 'trans.title', 'trans.body', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());

        if(!empty($_GET['title'])){
            $title = $_GET['title'];
            $list_pages->where('trans.title', 'like', '%'.$title.'%');     
        }
        if(!empty($_GET['created_at'])){
            $created_at = $_GET['created_at'];
            $list_pages->where('trans.created_at', '>=', ''.$created_at.' 00:00:00')->where('trans.created_at', '<=', ''.$created_at.' 23:59:59');           
        }
        if(!empty($_GET['last_update'])){
            $last_update = $_GET['last_update'];
            $list_pages->where('trans.updated_at', '>=', ''.$last_update.' 00:00:00')->where('trans.updated_at', '<=', ''.$last_update.' 23:59:59');           
        }
        if(!empty($_GET['published'])){
            $published = $_GET['published'];
            $list_pages->where('pages.published', '=', $published);           
        }
        if(!empty($_GET['orderby']) && !empty($_GET['sort'])){
            $orderby = $_GET['orderby'];
            $sort = $_GET['sort'];
            $list_pages->orderBy($orderby, $sort);           
        }
        
        $pages = $list_pages->paginate(10);
        // add to pagination other fields
        $pages->appends(['title' => $title, 'created_at' => $created_at,
         'last_update' => $last_update, 'orderby' => $orderby, 'sort' => $sort, 'published' => $published]);

        return view('backend.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PagesRequest $request)
    {
        $pages = new Pages;
        if($request->published){
            $pages->published = '1';
        }
        else{
            $pages->published = 2;
        }
        $pages->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $body = 'body_'.$language.'';
                $pages_trans = new PagesTrans;
                
                $pages_trans->title = $request->$title;
                $pages_trans->body = $request->$body;

                $pages_trans->lang = $language;
                $pages_trans->tid = $pages->id;
                
                $pages_trans->save();
            }
        }
        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }

        return redirect(''.$Currentlanguage.'/admin/pages');
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
        $pages = Pages::find($id);
        $trans = PagesTrans::where('tid', '=', $id)->get()->keyBy('lang')->toArray();
        return view('backend.pages.edit', compact('pages', 'trans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PagesRequest $request, $id)
    {
        $pages = Pages::find($id);
        if($request->published){
            $pages->published = '1';
        }
        else{
            $pages->published = 2;
        }
        $pages->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $body = 'body_'.$language.'';
                
                $pages_trans = PagesTrans::where('tid', '=', $pages->id)->where('lang', '=', $language)->first();
                if(empty($pages_trans)){
                    $pages_trans = new PagesTrans;
                }
                
                $pages_trans->title = $request->$title;
                $pages_trans->body = $request->$body;

                $pages_trans->lang = $language;
                $pages_trans->tid = $pages->id;
                
                $pages_trans->save();
            }
        }

        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/pages');
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
                $pages_trans = PagesTrans::where('lang', '=', $language)->where('tid', '=', $id)->first();
                if($pages_trans) {
                    $pages_trans->delete();
                }
            }
            $check_pages_trans =  PagesTrans::where('tid', '=', $id)->first();
            if(!$check_pages_trans){
                $pages = Pages::find($id);
                if (!empty($pages)){
                    $pages->delete();
                }
            }
        }

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/pages');
    }

    /**
     * Get single status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function single_status($status, $id)
    {
        $pages = Pages::find($id);
        $pages->published = $status;
        $pages->save();

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/pages');
    }

    /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $pages = PagesTrans::whereIn('tid', $request->ids)->where('lang', '=', Lang::getlocale())->get();
        return $pages;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $pages = Pages::find($request->ids);

        foreach ($pages as $item) {
            //languages
            $languages = Language::all();
            if($languages->count()){
                foreach ($request->language as $language) {
                    $pages_trans = PagesTrans::where('lang', '=', $language)->where('tid', '=', $item->id)->first();

                    if($pages_trans) {
                        $pages_trans->delete();
                    }
                }
                $check_pages_trans =  PagesTrans::where('tid', '=', $item->id)->first();
                if(!$check_pages_trans){
                    $item->delete();
                }
            }
            // end languages
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/pages');
    }

    /**
     * Bulk Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_status(Request $request,$status)
    {
        $pages = Pages::find($request->ids);
        if(!empty($pages)){
            foreach ($pages as $item) {
                $item->published = $status;
                $item->save();
            }
            Flash::success(trans('backend.saved_successfully'));
            $Currentlanguage = Lang::getLocale();
            return redirect(''.$Currentlanguage.'/admin/pages');
        }
        else
        {
            Flash::warning(trans('backend.nothing_selected'), 'alert-class');           
            return back();
        }
    }
}
