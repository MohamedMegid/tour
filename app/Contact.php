<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = ['name', 'phone', 'mail', 'user_id', 'title', 'message', 'reply_status'];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');   
    }

    public function reply() {
        return $this->hasOne('App\ContactReply', 'message_id');   
    }

}
