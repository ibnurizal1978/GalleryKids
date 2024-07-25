<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MembersonProfile
 *
 * @property int $id
 * @property int $user_id
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|MembersonProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MembersonProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MembersonProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|MembersonProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MembersonProfile whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MembersonProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MembersonProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MembersonProfile whereUserId($value)
 * @mixin \Eloquent
 */
class MembersonProfile extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo( User::class );
    }
}
