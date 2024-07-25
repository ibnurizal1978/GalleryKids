<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{
    protected $fillable = ['name','slug','display_name'];
}
