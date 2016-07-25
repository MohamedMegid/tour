<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'media_gallery';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    //public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   // protected $fillable = ['name', 'description'];
    protected $hidden = ['content_id'];

    /**
     * Image relation.
     *
     * 
     */
    public function media()
    {
        return $this->belongsTo('App\Media', 'media_id')->select(array('id', 'file', 'thumbnail'));
    }

}
