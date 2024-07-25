<?php

namespace Modules\Campaign\Entities;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaign';
    protected $fillable = ['title','description','start_date','end_date','image'];
    public function oldUpdate($data) {
        return $this->update($data);
    }
}
