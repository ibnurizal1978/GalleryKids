<?php

namespace Modules\Points\Entities;

use Illuminate\Database\Eloquent\Model;

class PointManage extends Model
{
    protected $table = 'points_manage';
    protected $fillable = ['user_id', 'type','points','date','time','post_id'];
    public function oldUpdate($data) {
        return $this->update($data);
    }
}
