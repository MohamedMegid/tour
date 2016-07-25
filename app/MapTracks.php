<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapTracks extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'maptracks';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'main_image_id'];
    
	/**
     * Image relation.
     *
     * 
     */
    public function image()
    {
       return $this->belongsTo('App\Media', 'main_image_id')->select(array('id', 'file', 'thumbnail'));
    }
}
