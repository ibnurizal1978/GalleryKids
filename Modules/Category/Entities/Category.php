<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','type','status'];

    /*
    added 11-12-20 for enabled category
    */
    public function scopeEnable($query)
    {
        return $query->where('status', 1);
    }

}
