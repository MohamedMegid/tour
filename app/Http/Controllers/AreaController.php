<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\AreaRequest;

use Response;
use App\Area;
use App\AreaTrans;
use App\City;
use App\CityTrans;
use Laracasts\Flash\Flash;
use Lang;
use Auth;
use App\Media;
use App\language;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Varibales
        $name = '';
        $created_at = '';
        $last_update = '';
        $orderby = '';
        $sort = '';

        $list = Area::leftJoin('area_trans as trans', 'area.id', '=', 'trans.tid')
             ->select('area.*', 'trans.lang', 'trans.name', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale());

        if(!empty($_GET['name'])){
            $name = $_GET['name'];
            $list->where('trans.name', 'like', '%'.$name.'%');     
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
        $items->appends(['name' => $name, 'created_at' => $created_at,
         'last_update' => $last_update, 'orderby' => $orderby, 'sort' => $sort]);

        return view('backend.area.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::leftJoin('city_trans as trans', 'city.id', '=', 'trans.tid')
             ->select('city.*', 'trans.lang', 'trans.name', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->get();

        return view('backend.area.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {
        $items = new Area;
        $items->city = $request->city;
        $items->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $name = 'name_'.$language.'';
                $trans = new AreaTrans;
                
                $trans->name = $request->$name;

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

        return redirect(''.$Currentlanguage.'/admin/area');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $items = Area::find($id);
        $trans = AreaTrans::where('tid', '=', $id)->get()->keyBy('lang')->toArray();
        $cities = City::leftJoin('city_trans as trans', 'city.id', '=', 'trans.tid')
             ->select('city.*', 'trans.lang', 'trans.name', 'trans.created_at', 'trans.updated_at')->where('trans.lang', '=', Lang::getlocale())->get();
        return view('backend.area.edit', compact('items', 'trans', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AreaRequest $request, $id)
    {
        $items = Area::find($id);
        $items->city = $request->city;
        $items->save();

        // translation
        $languages = Language::all();
        if($languages->count()){
            foreach ($request->language as $language) {
                $name = 'name_'.$language.'';
                
                $trans = AreaTrans::where('tid', '=', $items->id)->where('lang', '=', $language)->first();
                if(empty($trans)){
                    $trans = new AreaTrans;
                }
                
                $trans->name = $request->$name;

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
        return redirect(''.$Currentlanguage.'/admin/area');
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
                $trans = AreaTrans::where('lang', '=', $language)->where('tid', '=', $id)->first();
                if($trans) {
                    $trans->delete();
                }
            }
            $check_items_trans =  AreaTrans::where('tid', '=', $id)->first();
            if(!$check_items_trans){
                $items = Area::find($id);
                if (!empty($items)){
                    $items->delete();
                }
            }
        }

        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();

        return redirect(''.$Currentlanguage.'/admin/area');
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
        $items = AreaTrans::whereIn('tid', $request->ids)->where('lang', '=', Lang::getlocale())->get();
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
        $items = Area::find($request->ids);

        foreach ($items as $item) {
            //languages
            $languages = Language::all();
            if($languages->count()){
                foreach ($request->language as $language) {
                    $trans = AreaTrans::where('lang', '=', $language)->where('tid', '=', $item->id)->first();

                    if($trans) {
                        $trans->delete();
                    }
                }
                $check_items_trans =  AreaTrans::where('tid', '=', $item->id)->first();
                if(!$check_items_trans){
                    $item->delete();
                }
            }
            // end languages
        }
        
        Flash::success(trans('backend.deleted_successfully'));
        $Currentlanguage = Lang::getLocale();
        return redirect(''.$Currentlanguage.'/admin/area');
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

    public function getareas(Request $request, $id){
        if (!empty($id) && $id != 0){
            $spec_areas = Area::leftJoin('area_trans as trans', 'area.id', '=', 'trans.tid')
             ->select('area.id', 'trans.name')->where('area.city', '=', $id)->where('trans.lang', '=', Lang::getlocale())->get();
        }
        else{
            $spec_areas = ''; 
        }
        echo $spec_areas;
    }
}
