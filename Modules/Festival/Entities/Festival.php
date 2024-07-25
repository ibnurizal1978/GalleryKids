<?php

namespace Modules\Festival\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Reaction\Entities\Reaction;
use Modules\Archive\Entities\Archive;

class Festival extends Model
{
    protected $fillable = ['title','synopsis','url','content_start_date','content_expiry_date','members_only','targeted_age_group','category_id'];

    public function category()
    {
        return $this->belongsTo('Modules\Category\Entities\Category');
    }

    public function thumbnails()
    {
        return $this->hasMany('Modules\Festival\Entities\Thumbnail');
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactionable');
    }

    public function archives()
    {
        return $this->morphMany(Archive::class, 'archivable');
    }

     public function scopeEnable($query)
    {
        return $query->where('status', 'Enable');
    }

     public function scopeNonMembers($query)
    {
        return $query->where('members_only', 'No');
    }

     public function scopeValid($query)
    {
        return $query->where(function($query) {
                    $query->where(function($query){
                        $query->whereNull('content_start_date')
                        ->orWhere('content_start_date','<=',date('Y-m-d'));
                    })
                    ->where(function($query){
                        $query->whereNull('content_expiry_date')
                        ->orWhere('content_expiry_date','>=',date('Y-m-d'));
                    });
            });
    }

}
