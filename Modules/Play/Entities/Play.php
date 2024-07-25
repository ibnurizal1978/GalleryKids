<?php

namespace Modules\Play\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Reaction\Entities\Reaction;
use Modules\Archive\Entities\Archive;
use Illuminate\Database\Eloquent\Builder;
use Auth;

class Play extends Model
{
    protected $fillable = ['title','synopsis','url','thumbnail','status'];

    public function age_groups()
    {
        return $this->morphToMany('Modules\AgeGroup\Entities\AgeGroup', 'age_groupable');
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactionable');
    }

    public function archives()
    {
        return $this->morphMany(Archive::class, 'archivable');
    }

     public function archives_user()
    {
        return $this->morphMany(Archive::class, 'archivable')->where('user_id',Auth::user()->id);
    }

     public function scopeEnable($query)
    {
        return $query->where('status', 'Enable');
    }

    public function scopeAgeGroup($query)
    {
        $age = date('Y') - Auth::user()->year_of_birth; 
        
        switch ($age) {
                case ($age < 7):
                    $age_group = 'Less than 7 years old';
                    break;
                case ($age >= 7 && $age <= 10):
                    $age_group = '7-10 years old';
                    break;
                case ($age >= 11 && $age <= 13):
                    $age_group = '11-13 years old';
                    break;
                case ($age >= 14 && $age <= 15):
                    $age_group = '14-15 years old';
                    break;        
                case ($age > 15):
                    $age_group = 'More than 15 years old';
                    break;    
                
            } 

        return $query->whereHas('age_groups', function (Builder $query) use($age_group) {
         $query->where('age_group',$age_group);
        });

    }


}
