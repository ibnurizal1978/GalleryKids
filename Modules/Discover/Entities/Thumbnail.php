<?php

namespace Modules\Discover\Entities;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{

	protected $table = 'discover_thumbnails';

    protected $fillable = ['image','discover_id'];
}
