<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class ParentStudent extends Model
{
   protected $table = 'relation_user';
   protected $fillable = ['parent_id','child_id'];

    public function oldUpdate($data){
        return $this->update($data);
    }
}

