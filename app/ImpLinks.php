<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImpLinks extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'implink';

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
    protected $hidden = ['main_image_id', 'lang'];

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
