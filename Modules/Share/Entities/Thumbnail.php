<?php

namespace Modules\Share\Entities;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
	protected $table = 'share_thumbnails';
	
    protected $fillable = ['image','share_id'];
}
