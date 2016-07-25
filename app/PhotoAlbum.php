<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoAlbum extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'photoalbum';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   // protected $fillable = ['name', 'description'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['main_image_id', 'created_by', 'updated_by', 'lang'];

    /**
     * Image relation.
     *
     * 
     */
    public function image()
    {
       return $this->belongsTo('App\Media', 'main_image_id')->select(array('id', 'file', 'thumbnail'));
    }
    /**
     * Image relation.
     *
     * 
     */
    public function gallery()
    {
       return $this->hasMany('App\Gallery', 'content_id')->where('content_type', '=', '2')->select(array('content_id', 'media_id', 'created_at', 'updated_at'));
    }
}
