<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Lang;
class Section extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sections';

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
    protected $hidden = ['main_image_id', 'published', 'created_by', 'updated_by', 'lang', 'section_type'];

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
     * Translation relation.
     *
     * 
     */
    public function trans()
    {
        return $this->hasOne('App\SectionTrans', 'section_id')->where('lang', '=', Lang::getlocale());
    }
}