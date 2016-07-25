<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Author relation.
     *
     * 
     */
    public function trans()
    {
        return $this->hasOne('App\PermissionTrans', 'permission_id')->where('lang', '=', Lang::getlocale());
    }
}
