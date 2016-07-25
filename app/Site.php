<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Lang;

class Site extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sites';

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
    protected $hidden = ['main_image_id', 'published', 'created_by', 'updated_by', 'lang', 'section_id'];

    /**
     * Image relation.
     *
     * 
     */
    public function section()
    {
       return $this->belongsTo('App\Section', 'section_id')->select(array('id'));
    }

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
       return $this->hasMany('App\Gallery', 'content_id')->where('content_type', '=', '1')->select(array('content_id', 'media_id', 'created_at', 'updated_at'));
    }
    
    /**
     * Author relation.
     *
     * 
     */
    public function author()
    {
    	return $this->belongsTo('App\User', 'created_by')->select(array('id', 'name'));
    }
    /**
     * Author relation.
     *
     * 
     */
    public function last_updated_by()
    {
        return $this->belongsTo('App\User', 'updated_by')->select(array('id', 'name'));
    }
    /**
     * Translation relation only return name.
     *
     * 
     */
    public function site_section()
    {
        return $this->belongsTo('App\SectionTrans', 'section_id', 'section_id')->select(array('id', 'section_id', 'name'))->where('lang', '=', Lang::getlocale());
    }
    /**
     * Get the visits for the Site visit.
     */
    public function getvisits()
    {
        return $this->hasMany('App\Visit', 'content_id')->where('content_type', '=', '1')->where('lang', '=', Lang::getlocale());
     
    }

     public function visits()
    {
      $sum = $this->getvisits()->selectRaw('sum(total_visits) as total_visits, sum(web_visits) as web_visits, sum(android_visits) as android_visits, sum(ios_visits) as ios_visits, content_id')
        ->groupBy('content_id');

        return $sum; 
    }
    /**
     * comment relation.
     *
     * 
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'content_id')->select(array('content_id', 'user_id', 'comment', 'created_at', 'lang'));
    }
    /**
     * translation relation.
     *
     * 
     */
    public function TransLangCheck()
    {   
        return $this->hasOne('App\SiteTrans', 'site_id')->where('lang', '=', Lang::getlocale());
    }
    public function TransWithOtherLang()
    {   
        return $this->hasOne('App\SiteTrans', 'site_id')->where('lang', '!=', Lang::getlocale());
    }

    public function trans()
    {   
        if(!is_null($this->TransLangCheck())){
            return $this->TransLangCheck();
        }else{
            return $this->TransWithOtherLang();
        }
    }
    /**
     * Reviews relation.
     *
     * 
     */
    public function all_reviews()
    {
        return $this->hasMany('App\Review', 'content_id');
    }
    public function reviews()
    {
        return $this->all_reviews()->selectRaw('ROUND(avg(review), 1) as average, count(review) as count, content_id')->groupBy('content_id');
    }
}
