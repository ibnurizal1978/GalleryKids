<?php

namespace Modules\Event\Entities;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title','synopsis','thumbnail','date','type','status','location'];

     public function scopeEnable($query)
    {
        return $query->where('status', 'Enable');
    }
    
}
