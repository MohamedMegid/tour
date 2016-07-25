<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    
   /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'visits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['content_id', 'user_id', 'web_visits', 'android_visits', 'ios_visits', 'total_visits'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['content_type', 'content_id'];
}
