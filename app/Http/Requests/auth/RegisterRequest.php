<?php namespace App\Http\Requests\Auth;
 
use Illuminate\Foundation\Http\FormRequest;
 
class RegisterRequest extends FormRequest {
 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|confirmed|min:8',
            'country_id' => 'required',
            'city_id' => 'required',
            'area_id' => 'required',
        ];
    }
 
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
 
}