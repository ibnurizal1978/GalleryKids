<?php

namespace Modules\Points\Entities;

use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    protected $table = 'points';
    protected $fillable = ['name', 'value'];
    

    public function oldUpdate($data) {
        return $this->update($data);
    }
}
