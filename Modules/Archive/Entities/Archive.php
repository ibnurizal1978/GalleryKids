<?php

namespace Modules\Archive\Entities;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = ['user_id','archivable_id','archivable_type'];

    public function archivable()
    {
    	return $this->morphTo(); 
    }
}
