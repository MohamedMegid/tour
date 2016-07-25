<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Lang;

class Role extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Trans relation.
     *
     * 
     */
    public function trans()
    {
        return $this->hasOne('App\RoleTrans', 'role_id')->where('lang', '=', Lang::getlocale());
    }
}
