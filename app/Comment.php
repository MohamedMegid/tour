<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['content_type', 'content_id', 'comment', 'published'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['content_id', 'user_id', 'lang'];
    /**
     * site relation.
     *
     * 
     */
    public function site()
    {
        return $this->belongsTo('App\Site', 'content_id');
    }
    /**
     * Author relation.
     *
     * 
     */
    public function author()
    {
    	return $this->belongsTo('App\User', 'user_id')->select(array('id', 'name'));
    }
}
