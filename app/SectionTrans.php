<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionTrans extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sections_trans';
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id'];

}
