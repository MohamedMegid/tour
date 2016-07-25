<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUsPhone extends Model
{
    protected $table = 'contact_us_phones';
    protected $fillable = ['contact_id', 'phone'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'created_at', 'updated_at', 'counter', 'contact_id'];

    public function phones(){
        return $this->belongsTo('App\ContactInfo', 'contact_id');   
    }
}
