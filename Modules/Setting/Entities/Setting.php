<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['type', 'image','description','url'];
}
