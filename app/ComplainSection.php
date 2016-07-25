<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Lang;

class ComplainSection extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'complain_section';
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['lang'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Translation relation.
     *
     * 
     */
    public function trans()
    {
        return $this->hasOne('App\ComplainSectionTrans', 'tid')->where('lang', '=', Lang::getlocale());
    }
}
