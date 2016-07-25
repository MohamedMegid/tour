<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SiteRequest;
use App\Http\Controllers\Controller;

use App\Site;
use App\SiteTrans;
use App\Section;
use App\SectionTrans;
use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;
use MediaLibrary;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        // Varibales
        $title = '';
        $created_at = '';
        $last_update = '';
        $created_by = '';
        $updated_by = ''; 
        $orderby = '';
        $sort = '';
        $published = '';

        $list_sites = Site::with('reviews')->where('site_type', '=', $type)->leftJoin('sites_trans as trans', 'sites.id', '=', 'trans.site_id')
             ->select('sites.*', 'trans.lang', 'trans.title', 'trans.summary', 'trans.description', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());//->orderBy('trans.id', $sort)

        //dd($list_sites->get());
        if(!empty($_GET['title'])){
            $title = $_GET['title'];
            $list_sites->where('trans.title', 'like', '%'.$title.'%');     
        }
        if(!empty($_GET['section_id'])){
            $section_id = $_GET['section_id'];
            $list_sites->where('section_id', '=', $section_id);     
        }
        if(!empty($_GET['created_at'])){
            $created_at = $_GET['created_at'];
            $list_sites->where('sites.created_at', '>=', ''.$created_at.' 00:00:00')->where('sites.created_at', '<=', ''.$created_at.' 23:59:59');           
        }
        if(!empty($_GET['last_update'])){
            $last_update = $_GET['last_update'];
            $list_sites->where('sites.updated_at', '>=', ''.$last_update.' 00:00:00')->where('sites.updated_at', '<=', ''.$last_update.' 23:59:59');           
        }
        if(!empty($_GET['created_by'])){
            $created_by = $_GET['created_by'];
            $list_sites->where('sites.created_by', '=', $created_by);           
        }
        if(!empty($_GET['updated_by'])){
            $updated_by = $_GET['updated_by'];
            $list_sites->where('sites.updated_by', '=', $updated_by);           
        }
        if(!empty($_GET['published'])){
            $published = $_GET['published'];
            $list_sites->where('sites.published', '=', $published);           
        }
        if(!empty($_GET['orderby']) && !empty($_GET['sort'])){
            $orderby = $_GET['orderby'];
            $sort = $_GET['sort'];
            $list_sites->orderBy($orderby, $sort);           
        }
        
        $sites = $list_sites->paginate(10);

        // add to pagination other fields
        $sites->appends(['title' => $title, 'created_at' => $created_at,
         'last_update' => $last_update, 'created_by' => $created_by, 'updated_by' => $updated_by, 'orderby' => $orderby, 'sort' => $sort, 'published' => $published]);
        
        $authors = Site::where('site_type', '=', $type)->select('created_by')->groupBy('created_by')->get();
        $editors = Site::where('site_type', '=', $type)->select('updated_by')->groupBy('updated_by')->get();

        $sections = Section::where('section_type', '=', $type)->leftJoin('sections_trans as trans', 'sections.id', '=', 'trans.section_id')
             ->select('sections.*', 'trans.lang', 'trans.name', 'trans.description', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->get();//->orderBy('trans.id', $sort)


        return view('backend.sites.index', compact('sites', 'type', 'authors', 'editors', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $sections = Section::where('section_type', '=', $type)->where('published', '=', '1')->get();
        return view('backend.sites.create', compact('type', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteRequest $request, $type)
    {
        $site = new Site;
        $site->main_image_id = $request->main_image_id;
        $site->site_type = $type;// 1 for services sites 2 for locations sites
        $site->section_id = $request->section;
        $site->latitude = $request->latitude;
        $site->longitude = $request->longitude;
        $site->created_by = Auth::user()->id;
        $site->updated_by = Auth::user()->id;
        if($request->published){
            $site->published = '1';
        }
        if($request->important_site){
            $site->important_site = '1';
        }
        if($request->feature_site){
            $site->feature_site = '1';
        }
        if($request->social_published){
            $site->social_published = '1';
        }
        $site->save();

        // Gallery
        $media = new MediaLibrary;
        $content_type = '1';//1 for sites
        $content_id = $site->id;
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
                $description = 'description_'.$language.'';

                $site_trans = new SiteTrans;
                $site_trans->site_id = $site->id;
                $site_trans->lang = $language;
                $site_trans->title = $request->$title;
                $site_trans->summary = $request->$summary;
                $site_trans->description = $request->$description;
                $site_trans->save();
            }
        }
        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }

        return redirect(''.$Currentlanguage.'/admin/sites/'.$type.'');
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
    public function edit($type, $id)
    {
        $site = Site::find($id);
        $trans = SiteTrans::where('site_id', '=', $id)->get()->keyBy('lang')->toArray();
        $media = Media::where('id', '=', $site->main_image_id)->first();

        //gallery
        $content_type = '1';
        $content_id = $id;
        $category_id = null;
        $is_main = '0';
        $gallery = new MediaLibrary;
        $gallery = $gallery->select_from_gallery($content_type, $content_id, $category_id, $is_main);
        //end gallery

        $sections = Section::where('published', '=', '1')->get();
        return view('backend.sites.edit', compact('site', 'type', 'media', 'gallery', 'trans', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SiteRequest $request, $type, $id)
    {
        $site = Site::find($id);
        $site->main_image_id = $request->main_image_id;
        $site->site_type = $type;// 1 for services sites 2 for locations sites
        $site->section_id = $request->section;
        $site->latitude = $request->latitude;
        $site->longitude = $request->longitude;
        $site->created_by = Auth::user()->id;
        $site->updated_by = Auth::user()->id;
        if($request->published){
            $site->published = '1';
        }else{
            $site->published = '2';
        }
        if($request->important_site){
            $site->important_site = '1';
        }else{
            $site->important_site = '2';
        }
        if($request->feature_site){
            $site->feature_site = '1';
        }else{
            $site->feature_site = '2';
        }
        if($request->social_published){
            $site->social_published = '1';
        }else{
            $site->social_published = '2';
        }
        $site->save();

        // Gallery
        $media = new MediaLibrary;
        $content_type = '1';//1 for sites
        $content_id = $site->id;
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
                $description = 'description_'.$language.'';

                $site_trans = SiteTrans::where('site_id', '=', $site->id)->where('lang', '=', $language)->first();
                if(empty($site_trans)){
                    $site_trans = new SiteTrans;
                }
                $site_trans->site_id = $site->id;
                $site_trans->lang = $language;
                $site_trans->title = $request->$title;
                $site_trans->summary = $request->$summary;
                $site_trans->description = $request->$description;
                $site_trans->save();
            }
        }
        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/sites/'.$type.'');
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
        $type = $request->type;

        //languages
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $site_trans = SiteTrans::where('lang', '=', $language)->where('site_id', '=', $id)->first();
                if($site_trans) {
                    $site_trans->delete();
                }
            }
            $check_site_trans =  SiteTrans::where('site_id', '=', $id)->first();
            if(!$check_site_trans){
                $site = Site::find($id);
                $site->delete();
            }
        }
        // end languages
        // $site = Site::find($id);
        // $site->delete();

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/sites/'.$type.'');
    }
    /**
     * Get single status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function single_status($type, $status, $id)
    {
        $site = Site::find($id);
        $site->published = $status;
        $site->save();

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/sites/'.$type.'');
    }
     /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $sites = SiteTrans::whereIn('site_id', $request->ids)->where('lang', '=', Lang::getlocale())->get();
        //dd($sites);
        return $sites;
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $sites = Site::find($request->ids);

        foreach ($sites as $site) {
           // $site->delete();
            //languages
            $languages = Language::all();
            if($languages->count()){
                foreach ($request->language as $language) {
                    $site_trans = SiteTrans::where('lang', '=', $language)->where('site_id', '=', $site->id)->first();
                    if($site_trans) {
                        $site_trans->delete();
                    }
                }
                $check_site_trans =  SiteTrans::where('site_id', '=', $site->id)->first();
                if(!$check_site_trans){
                    $site->delete();
                }
            }
            // end languages
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/sites/'.$request->type.'');
    }
    /**
     * Bulk Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_status(Request $request, $type, $status)
    {
        $sites = Site::find($request->ids);
        if(!empty($sites)){
            foreach ($sites as $site) {
                $site->published = $status;
                $site->save();
            }
            Flash::success(trans('backend.saved_successfully'));
            $Currentlanguage = Lang::getLocale();
            return redirect(''.$Currentlanguage.'/admin/sites/'.$type.'');
        }
        else
        {
            Flash::warning(trans('backend.nothing_selected'), 'alert-class');           
            return back();
        }
    }
}