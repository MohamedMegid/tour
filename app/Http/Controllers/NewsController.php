<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\NewsRequest;

use App\News;
use App\NewsTrans;
use App\Section;
use App\SectionTrans;
use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;

class NewsController extends Controller
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

        $list_news = News::leftJoin('news_trans as trans', 'news.id', '=', 'trans.tid')
             ->select('news.*', 'trans.lang', 'trans.title', 'trans.summary', 'trans.body', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());

        if(!empty($_GET['title'])){
            $title = $_GET['title'];
            $list_news->where('trans.title', 'like', '%'.$title.'%');     
        }
        if(!empty($_GET['created_at'])){
            $created_at = $_GET['created_at'];
            $list_news->where('trans.created_at', '>=', ''.$created_at.' 00:00:00')->where('trans.created_at', '<=', ''.$created_at.' 23:59:59');           
        }
        if(!empty($_GET['last_update'])){
            $last_update = $_GET['last_update'];
            $list_news->where('trans.updated_at', '>=', ''.$last_update.' 00:00:00')->where('trans.updated_at', '<=', ''.$last_update.' 23:59:59');           
        }
        if(!empty($_GET['published'])){
            $published = $_GET['published'];
            $list_news->where('news.published', '=', $published);           
        }
        if(!empty($_GET['orderby']) && !empty($_GET['sort'])){
            $orderby = $_GET['orderby'];
            $sort = $_GET['sort'];
            $list_news->orderBy($orderby, $sort);           
        }
        
        $news = $list_news->paginate(10);
        // add to pagination other fields
        $news->appends(['title' => $title, 'created_at' => $created_at,
         'last_update' => $last_update, 'orderby' => $orderby, 'sort' => $sort, 'published' => $published]);

        return view('backend.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        $news = new News;
        $news->main_image_id = $request->main_image_id;
        if($request->important_news){
            $news->important_news = '1';
        }
        if($request->social_published){
            $news->social_published = '1';
        }
        if($request->published){
            $news->published = '1';
        }
        $news->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $summary = 'summary_'.$language.'';
                $body = 'body_'.$language.'';
                $news_trans = new NewsTrans;
                
                $news_trans->title = $request->$title;
                $news_trans->summary = $request->$summary;
                $news_trans->body = $request->$body;

                $news_trans->lang = $language;
                $news_trans->tid = $news->id;
                
                $news_trans->save();
            }
        }
        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }

        return redirect(''.$Currentlanguage.'/admin/news');
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
        $news = News::find($id);
        $trans = NewsTrans::where('tid', '=', $id)->get()->keyBy('lang')->toArray();
        $media = Media::where('id', '=', $news->main_image_id)->first();
        return view('backend.news.edit', compact('news', 'media', 'trans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {
        $news = News::find($id);
        $news->main_image_id = $request->main_image_id;
        if($request->important_news){
            $news->important_news = '1';
        }
        else{
            $news->important_news = '2';
        }
        if($request->social_published){
            $news->social_published = '1';
        }
        else{
            $news->social_published = '2';
        }
        if($request->published){
            $news->published = '1';
        }
        else{
            $news->published = '2';
        }
        $news->save();

// translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $summary = 'summary_'.$language.'';
                $body = 'body_'.$language.'';
                
                $news_trans = NewsTrans::where('tid', '=', $news->id)->where('lang', '=', $language)->first();
                if(empty($news_trans)){
                    $news_trans = new NewsTrans;
                }
                
                $news_trans->title = $request->$title;
                $news_trans->summary = $request->$summary;
                $news_trans->body = $request->$body;

                $news_trans->lang = $language;
                $news_trans->tid = $news->id;
                
                $news_trans->save();
            }
        }

        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/news');
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
                $news_trans = NewsTrans::where('lang', '=', $language)->where('tid', '=', $id)->first();
                if($news_trans) {
                    $news_trans->delete();
                }
            }
            $check_news_trans =  NewsTrans::where('tid', '=', $id)->first();
            if(!$check_news_trans){
                $news = News::find($id);
                if (!empty($news)){
                    $news->delete();
                }
            }
        }

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/news');
    }

    /**
     * Get single status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function single_status($status, $id)
    {
        $news = News::find($id);
        $news->published = $status;
        $news->save();

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/news');
    }

    /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $news = NewsTrans::whereIn('tid', $request->ids)->where('lang', '=', Lang::getlocale())->get();
        return $news;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $news = News::find($request->ids);

        foreach ($news as $item) {
            //languages
            $languages = Language::all();
            if($languages->count()){
                foreach ($request->language as $language) {
                    $news_trans = NewsTrans::where('lang', '=', $language)->where('tid', '=', $item->id)->first();

                    if($news_trans) {
                        $news_trans->delete();
                    }
                }
                $check_news_trans =  NewsTrans::where('tid', '=', $item->id)->first();
                if(!$check_news_trans){
                    $item->delete();
                }
            }
            // end languages
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/news');
    }
    /**
     * Bulk Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_status(Request $request,$status)
    {
        $news = News::find($request->ids);
        if(!empty($news)){
            foreach ($news as $item) {
                $item->published = $status;
                $item->save();
            }
            Flash::success(trans('backend.saved_successfully'));
            $Currentlanguage = Lang::getLocale();
            return redirect(''.$Currentlanguage.'/admin/news');
        }
        else
        {
            Flash::warning(trans('backend.nothing_selected'), 'alert-class');           
            return back();
        }
    }
}
