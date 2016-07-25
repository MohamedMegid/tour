<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactReply extends Model
{
    protected $table = 'contacts_reply';

    protected $fillable = ['message_id', 'reply_message'];

    public function contact() {
		return $this->belongsTo('App\Contact');
	}
}
