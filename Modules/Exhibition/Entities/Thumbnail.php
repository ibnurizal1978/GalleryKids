<?php

namespace Modules\Exhibition\Entities;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
	protected $table = 'exhibition_thumbnails';

    protected $fillable = ['image','exhibition_id'];
}
