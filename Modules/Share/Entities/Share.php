<?php

namespace Modules\Share\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Reaction\Entities\Reaction;
use Modules\Archive\Entities\Archive;
use Auth;

class Share extends Model
{
    protected $fillable = ['name','description','Inspired_by','hashtags','status','non_member_name','age','creator','user_id','featured'];

    protected $casts = [
        'hashtags' => 'array',
    ];

    public function thumbnails()
    {
        return $this->hasMany('Modules\Share\Entities\Thumbnail');
    }
    public function user()
    {
        return $this->belongsTo('\App\User','user_id');
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
}
