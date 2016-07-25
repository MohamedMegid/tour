<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    protected $table = 'contact_info';
    protected $fillable = ['title', 'mail', 'phone'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'created_at', 'updated_at', 'phone'];

    public function phones(){
        return $this->hasMany('App\ContactUsPhone', 'contact_id');   
    }
}
