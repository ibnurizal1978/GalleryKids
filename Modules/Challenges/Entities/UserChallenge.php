<?php

namespace Modules\Challenges\Entities;

use Illuminate\Database\Eloquent\Model;

class UserChallenge extends Model
{
   protected $table = 'user_challanges';
    protected $fillable = ['challange_id', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
