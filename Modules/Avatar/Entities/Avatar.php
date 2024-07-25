<?php

namespace Modules\Avatar\Entities;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $fillable = ['image','status'];

     public function scopeEnable($query)
    {
        return $query->where('status', 'Enable');
    }
}
