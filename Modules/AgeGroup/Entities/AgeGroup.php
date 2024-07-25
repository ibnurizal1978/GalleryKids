<?php

namespace Modules\AgeGroup\Entities;

use Illuminate\Database\Eloquent\Model;

class AgeGroup extends Model
{
    protected $fillable = ['age_group'];

    public function creates()
    {
        return $this->morphedByMany('Modules\Create\Entities\Create', 'age_groupable');
    }

    public function discovers()
    {
        return $this->morphedByMany('Modules\Discover\Entities\Discover', 'age_groupable');
    }

    public function plays()
    {
        return $this->morphedByMany('Modules\Play\Entities\Play', 'age_groupable');
    }

    public function exhibitions()
    {
        return $this->morphedByMany('Modules\Exhibition\Entities\Exhibition', 'age_groupable');
    }

}
