<?php

namespace Modules\Question\Entities;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question','file','status','non_member_name','age','creator','user_id','featured'];

    
     public function user()
    {
        return $this->belongsTo('App\User');
    }

     public function scopeEnable($query)
    {
        return $query->where('status', 'Enable');
    }
}
