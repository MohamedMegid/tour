<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoAlbum extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'videoalbum';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_by', 'updated_by', 'lang'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
