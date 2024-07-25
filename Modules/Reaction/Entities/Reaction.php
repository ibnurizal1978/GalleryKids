<?php

namespace Modules\Reaction\Entities;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $fillable = ['reaction', 'user_id', 'reactionable_id', 'reactionable_type'];

    public function reactionable()
    {
    	return $this->morphTo(); 
    }

}
