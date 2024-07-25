<?php

namespace Modules\Create\Entities;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
	protected $table = 'create_thumbnails';

    protected $fillable = ['image','create_id'];
}
