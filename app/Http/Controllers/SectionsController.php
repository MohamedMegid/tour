<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\SectionRequest;
use App\Http\Controllers\Controller;

use App\Section;
use App\SectionTrans;
use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;
use CheckPermission;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        // Varibales
        $name = '';
        $created_at = '';
        $last_update = '';
        $created_by = '';
        $updated_by = ''; 
        $orderby = '';
        $sort = '';
        $published = '';

        $list_sections = Section::where('section_type', '=', $type)->leftJoin('sections_trans as trans', 'sections.id', '=', 'trans.section_id')
             ->select('sections.*', 'trans.lang', 'trans.name', 'trans.description', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());//->orderBy('trans.id', $sort)

        //dd($list_sections->get());
        if(!empty($_GET['name'])){
            $name = $_GET['name'];
            $list_sections->where('trans.name', 'like', '%'.$name.'%');     
        }
        if(!empty($_GET['created_at'])){
            $created_at = $_GET['created_at'];
            $list_sections->where('sections.created_at', '>=', ''.$created_at.' 00:00:00')->where('sections.created_at', '<=', ''.$created_at.' 23:59:59');           
        }
        if(!empty($_GET['last_update'])){
            $last_update = $_GET['last_update'];
            $list_sections->where('sections.updated_at', '>=', ''.$last_update.' 00:00:00')->where('sections.updated_at', '<=', ''.$last_update.' 23:59:59');           
        }
        if(!empty($_GET['created_by'])){
            $created_by = $_GET['created_by'];
            $list_sections->where('sections.created_by', '=', $created_by);           
        }
        if(!empty($_GET['updated_by'])){
            $updated_by = $_GET['updated_by'];
            $list_sections->where('sections.updated_by', '=', $updated_by);           
        }
        if(!empty($_GET['published'])){
            $published = $_GET['published'];
            $list_sections->where('sections.published', '=', $published);           
        }
        if(!empty($_GET['orderby']) && !empty($_GET['sort'])){
            $orderby = $_GET['orderby'];
            $sort = $_GET['sort'];
            $list_sections->orderBy($orderby, $sort);           
        }
        
        $sections = $list_sections->paginate(10);

        // add to pagination other fields
        $sections->appends(['name' => $name, 'created_at' => $created_at,
         'last_update' => $last_update, 'created_by' => $created_by, 'updated_by' => $updated_by, 'orderby' => $orderby, 'sort' => $sort, 'published' => $published]);
        
        $authors = Section::where('section_type', '=', $type)->select('created_by')->groupBy('created_by')->get();
        $editors = Section::where('section_type', '=', $type)->select('updated_by')->groupBy('updated_by')->get();

        return view('backend.sections.index', compact('sections', 'type', 'authors', 'editors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $type)
    {
        // Start check permission
        //$permission = new CheckPermission;
        //$permission->CheckPermission(1);//permission id
        // End check permission
        return view('backend.sections.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request, $type)
    {
        $section = new Section;
        // $section->name = $request->name;
        // $section->description = $request->description;
        $section->main_image_id = $request->main_image_id;
        $section->section_type = $type;// 1 for services sections 2 for locations sections
        $section->created_by = Auth::user()->id;
        $section->updated_by = Auth::user()->id;
        if($request->published){
            $section->published = '1';
        }
        $section->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $name = 'name_'.$language.'';
                $description = 'description_'.$language.'';

                $section_trans = new SectionTrans;
                $section_trans->section_id = $section->id;
                $section_trans->lang = $language;
                $section_trans->name = $request->$name;
                $section_trans->description = $request->$description;
                $section_trans->save();
            }
        }
        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/sections/'.$type.'');
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
        $section = Section::find($id);
        $trans = SectionTrans::where('section_id', '=', $id)->get()->keyBy('lang')->toArray();
        $media = Media::where('id', '=', $section->main_image_id)->first();
        return view('backend.sections.edit', compact('section', 'type', 'media', 'trans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, $type, $id)
    {
        $section = Section::find($id);
        $section->main_image_id = $request->main_image_id;
        $section->section_type = $type;// 0 for services sections 1 for locations sections
        $section->updated_by = Auth::user()->id;
        if($request->published){
            $section->published = '1';
        }else{
            $section->published = '2';
        }
        $section->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $name = 'name_'.$language.'';
                $description = 'description_'.$language.'';

                $section_trans = SectionTrans::where('section_id', '=', $section->id)->where('lang', '=', $language)->first();
                if(empty($section_trans)){
                    $section_trans = new SectionTrans;
                }
                $section_trans->section_id = $section->id;
                $section_trans->lang = $language;
                $section_trans->name = $request->$name;
                $section_trans->description = $request->$description;
                $section_trans->save();
            }
        }
        session()->forget('default_contnent_language');
        // end translation

        Flash::success(trans('backend.updated_successfully'));
        $Currentlanguage = Lang::getLocale();
        if($request->back){
            return back();
        }
        return redirect(''.$Currentlanguage.'/admin/sections/'.$type.'');
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
                $section_trans = SectionTrans::where('lang', '=', $language)->where('section_id', '=', $id)->first();
                if($section_trans) {
                    $section_trans->delete();
                }
            }
            $check_section_trans =  SectionTrans::where('section_id', '=', $id)->first();
            if(!$check_section_trans){
                $section = Section::find($id);
                $section->delete();
            }
        }
        // end languages
        // $section = Section::find($id);
        // $section->delete();

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/sections/'.$type.'');
    }
    /**
     * Get single status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function single_status($type, $status, $id)
    {
        $section = Section::find($id);
        $section->published = $status;
        $section->save();

        Flash::success(trans('backend.saved_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/sections/'.$type.'');
    }
     /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $sections = SectionTrans::whereIn('section_id', $request->ids)->where('lang', '=', Lang::getlocale())->get();
        //dd($sections);
        return $sections;
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy(Request $request)
    {
        $sections = Section::find($request->ids);

        foreach ($sections as $section) {
           // $section->delete();
            //languages
            $languages = Language::all();
            if($languages->count()){
                foreach ($request->language as $language) {
                    $section_trans = SectionTrans::where('lang', '=', $language)->where('section_id', '=', $section->id)->first();
                    if($section_trans) {
                        $section_trans->delete();
                    }
                }
                $check_section_trans =  SectionTrans::where('section_id', '=', $section->id)->first();
                if(!$check_section_trans){
                    $section->delete();
                }
            }
            // end languages
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/sections/'.$request->type.'');
    }
    /**
     * Bulk Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_status(Request $request, $type, $status)
    {
        $sections = Section::find($request->ids);
        if(!empty($sections)){
            foreach ($sections as $section) {
                $section->published = $status;
                $section->save();
            }
            Flash::success(trans('backend.saved_successfully'));
            $Currentlanguage = Lang::getLocale();
            return redirect(''.$Currentlanguage.'/admin/sections/'.$type.'');
        }
        else
        {
            Flash::warning(trans('backend.nothing_selected'), 'alert-class');           
            return back();
        }
    }
}