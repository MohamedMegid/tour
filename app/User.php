<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'phone'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'active'];
    /**
     * Roles relation.
     *
     * 
     */
    public function user_role()
    {
        return $this->hasOne('App\UserRole', 'user_id');
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

}
