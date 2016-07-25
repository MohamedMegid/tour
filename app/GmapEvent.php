<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GmapEvent extends Model
{
    protected $table = 'gmap_event';
    protected $fillable = ['address', 'latitude', 'longitude', 'event_id'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'created_at', 'updated_at', 'address'];
}
