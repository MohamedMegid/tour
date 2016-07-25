<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gmap extends Model
{
    protected $table = 'gmap';
    protected $fillable = ['address', 'latitude', 'longitude'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'created_at', 'updated_at', 'address'];
}
