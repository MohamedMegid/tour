<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Request;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Language;
use App\Translation;
use App\Http\Requests\LanguageRequest;
use Laracasts\Flash\Flash;
use Route;
use Lang;
use Input;
use DB;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
  /*  public function word($id)
    {
         $Currentlanguage = Lang::getLocale();
        $translation = DB::table('translations')
        ->join('languages_translations', function ($join_languages_translations) use ($id) {
            $join_languages_translations->on('translations.id', '=', 'languages_translations.word_id')->where('translations.id', '=', $id);
        })
        ->join('languages', function ($join_languages) use ($Currentlanguage) {
            $join_languages->on('languages.id', '=', 'languages_translations.lang_id')->where('code','=', $Currentlanguage);
        })
         ->groupBy('translations.id')->distinct()->first();
        
        return $translation;
    }*/
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page_title = Translation::find(1)->word(1);
        $defualt_lang = Translation::find(1)->word(2);
        $languages = Language::all();
        return view('backend.language.index', compact('languages', 'page_title', 'defualt_lang'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function all()
    {
        $languages = Language::orderBy('main', 'Asc')->get();
        return $languages;
    }
     /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function CurrentLang()
    {
        $language = Lang::getLocale();
        if(!empty($language ))
        {
            $Currentlanguage = Lang::getLocale();
        }
        else
        {
            $defualt_lang = Language::where('main', '=', '1')->first();
            $Currentlanguage = $defualt_lang->code;
        }
        return $Currentlanguage;
    }
     /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function LangDirection()
    {
        $Languages = Language::all();
        foreach($Languages as $lang){
            if($lang->code == Lang::getLocale())
            {
               $Currentlanguage = Language::where('code', '=', $lang->code)->first();
               $LangDirection = $Currentlanguage->direction;
            }
            else
            {
            $defualt_lang = Language::where('main', '=', '1')->first();
            $LangDirection = $defualt_lang->direction;
            }
        }

        return $LangDirection;
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(LanguageRequest $request)
    {
        $language = new Language;
        $language->name = $request->input('name');
        $language->code = $request->input('code');
        $language->direction = $request->input('direction');
        $language->save();
        
        Flash::success("تم إنشاء المستخدم بنجاح");
        $Currentlanguage = Lang::getLocale();
        Route::get(''.$Currentlanguage.'/admin/languages', [
         'as' => 'systemlanguages', 'uses' => 'LanguageController@index'
        ]);
        $url = route('systemlanguages');
        $redirect = redirect()->route('systemlanguages');
        return $redirect;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update()
    {
        $languages = Language::all();
        foreach ($languages as $language) {
            $language->main = '0';
            $language->save();
        }

        $defualt_lang_id = Input::get('main');
        $defualt_lang = Language::find($defualt_lang_id);
        $defualt_lang->main = '1';
        $defualt_lang->save();

        Flash::success("تم إنشاء المستخدم بنجاح");
        $Currentlanguage = Lang::getLocale();
        Route::get(''.$Currentlanguage.'/admin/languages', [
         'as' => 'systemlanguages', 'uses' => 'LanguageController@index'
        ]);
        $url = route('systemlanguages');
        $redirect = redirect()->route('systemlanguages');
        return $redirect;
        
    }
    /**
     * Confirm Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroyconfirm($id)
    {
        $page_title = 'Users';
        $language = Language::find($id);
        return view('backend.language.confirmdelete', compact('language', 'page_title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $language = Language::find($id);
        $language->delete();

        Flash::success("تم إنشاء المستخدم بنجاح");
        Route::get('admin/languages', [
         'as' => 'systemlanguages', 'uses' => 'LanguageController@index'
        ]);
        $url = route('systemlanguages');
        $redirect = redirect()->route('systemlanguages');
        return $redirect;
    }
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function bulkdeleteconfirm()
    {  
       if(!empty($_POST['check_list'])) {
          $languages = Language::find($_POST['check_list']);
       }
       else
       {
            Flash::warning('لم يتم الاختيار', 'alert-class');
            $Currentlanguage = Lang::getLocale();
            return redirect(''.$Currentlanguage.'/admin/languages');
       }
      return view('backend.language.bulkconfirmdelete', compact('languages'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function bulkdestroy()
    {
            $languages_checked = Input::get('language_ids');
            if(is_array($languages_checked))
            {
                 foreach ($languages_checked as $language_id) {
                   $language = Language::find($language_id);
                   $language->delete();
                 }
            }
            Flash::success("تم حذف المستخدمين بنجاح");
            $Currentlanguage = Lang::getLocale();
            Route::get(''.$Currentlanguage.'/admin/languages', [
                     'as' => 'languages', 'uses' => 'LanguageController@index'
             ]);
             $redirect = redirect()->route('languages');
              return $redirect;
    }
}
