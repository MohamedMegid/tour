<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Language;

class BannersRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = '';
        $languages = Language::all();      
        $rules['language'] = 'required';
      
        if($languages->count()) {
            foreach ($languages as $key => $language) {
                $code = $language->code;
                if(!empty(Request::input('language'))){
                    foreach(Request::input('language') as $key2 => $lang){
                        if($lang == $code){
                            $default_language = Language::where('main', '=', '1')->where('code', '=', $lang)->first();
                            session()->forget('default_contnent_language');
                            if($default_language){
                                 session(['default_contnent_language' => 'yes']);
                            }
                            else{
                                 session(['default_contnent_language' => 'no']);
                            }
                            $rules['title_'.$code.''] = 'required|max:255';
                            $rules['link'] = 'required';
                            $rules['main_image_id'] = 'required';
                        }
                    }
                }
            }

        }
        
        return $rules;
    }
}
