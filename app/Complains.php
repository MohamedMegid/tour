<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complains extends Model
{
    protected $table = 'complains';

    /**
     * Image relation.
     *
     * 
     */
	public function section()
    {
        return $this->belongsTo('App\ComplainSection', 'complain_section_id');
    }

    /**
     * Image relation.
     *
     * 
     */
	public function image()
    {
       return $this->belongsTo('App\Media', 'photo')->select(array('id', 'file', 'thumbnail'));
    }
}
