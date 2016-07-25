<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ComplainSectionRequest;


use App\ComplainSection;
use App\ComplainSectionTrans;

use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;

class ComplainSections extends Controller
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

        $list = ComplainSection::leftJoin('complain_section_trans as trans', 'complain_section.id', '=', 'trans.tid')
             ->select('complain_section.*', 'trans.lang', 'trans.title', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());

        if(!empty($_GET['complain_section_id'])){
            $complain_section_id = $_GET['complain_section_id'];
            $list->where('trans.id', '=', $complain_section_id);     
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
        $complain_sections = ComplainSectionTrans::where('lang', '=', Lang::getlocale())->get();
        return view('backend.complainsections.index', compact('items', 'complain_sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.complainsections.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComplainSectionRequest $request)
    {
        $items = new ComplainSection;
        $items->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                $trans = new ComplainSectionTrans;
                
                $trans->title = $request->$title;

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

        return redirect(''.$Currentlanguage.'/admin/complains-sections');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $items = ComplainSection::find($id);
        $trans = ComplainSectionTrans::where('tid', '=', $id)->get()->keyBy('lang')->toArray();
        return view('backend.complainsections.edit', compact('items', 'trans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComplainSectionRequest $request, $id)
    {
        $items = ComplainSection::find($id);
        $items->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $title = 'title_'.$language.'';
                
                $trans = ComplainSectionTrans::where('tid', '=', $items->id)->where('lang', '=', $language)->first();
                if(empty($trans)){
                    $trans = new ComplainSectionTrans;
                }
                
                $trans->title = $request->$title;
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
        return redirect(''.$Currentlanguage.'/admin/complains-sections');
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
                $trans = ComplainSectionTrans::where('lang', '=', $language)->where('tid', '=', $id)->first();
                if($trans) {
                    $trans->delete();
                }
            }
            $check_items_trans =  ComplainSectionTrans::where('tid', '=', $id)->first();
            if(!$check_items_trans){
                $items = ComplainSection::find($id);
                if (!empty($items)){
                    $items->delete();
                }
            }
        }

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/complains-sections');
    }

    /**
     * confirm bulk delete and return resources to use it in model.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_destroy_confirm(Request $request)
    {
        $items = ComplainSectionTrans::whereIn('tid', $request->ids)->where('lang', '=', Lang::getlocale())->get();
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
        $items = ComplainSection::find($request->ids);

        foreach ($items as $item) {
            //languages
            $languages = Language::all();
            if($languages->count()){
                foreach ($request->language as $language) {
                    $trans = ComplainSectionTrans::where('lang', '=', $language)->where('tid', '=', $item->id)->first();

                    if($trans) {
                        $trans->delete();
                    }
                }
                $check_items_trans =  ComplainSectionTrans::where('tid', '=', $item->id)->first();
                if(!$check_items_trans){
                    $item->delete();
                }
            }
            // end languages
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/complains-sections');
    }
}
