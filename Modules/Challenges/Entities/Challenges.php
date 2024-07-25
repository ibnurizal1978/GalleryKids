<?php

namespace Modules\Challenges\Entities;

use Illuminate\Database\Eloquent\Model;

class Challenges extends Model
{
    protected $table = 'challenges';
    protected $fillable = ['name', 'status'];
    
public function scopeEnable($query)
    {
        return $query->where('status', 'Enable');
    }
    public function oldUpdate($data) {
        return $this->update($data);
    }
}
