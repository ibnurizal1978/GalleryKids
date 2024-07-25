<?php

namespace Modules\Festival\Entities;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
	protected $table = 'festival_thumbnails';

    protected $fillable = ['image','festival_id'];
}
