<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Lang;

class News extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'news';

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
    protected $hidden = ['main_image_id', 'published', 'created_by', 'updated_by', 'lang'];


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
     * Author relation.
     *
     * 
     */
    public function author()
    {
    	return $this->belongsTo('App\User', 'created_by');
    }
    /**
     * Author relation.
     *
     * 
     */
    public function last_updated_by()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }
    /**
     * Get the visits for the Site visit.
     */
    public function getvisits()
    {
        return $this->hasMany('App\Visit', 'content_id')->where('content_type', '=', '2')->where('lang', '=', Lang::getlocale());
     
    }

     public function visits()
    {
      $sum = $this->getvisits()->selectRaw('sum(total_visits) as total_visits, sum(web_visits) as web_visits, sum(android_visits) as android_visits, sum(ios_visits) as ios_visits, content_id')
        ->groupBy('content_id');

        return $sum; 
    }

}
