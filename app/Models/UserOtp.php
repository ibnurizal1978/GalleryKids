<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserOtp
 *
 * @property int $id
 * @property int $user_id
 * @property string $otp
 * @property \Illuminate\Support\Carbon $last_sent_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereLastSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOtp whereUserId($value)
 * @mixin \Eloquent
 */
class UserOtp extends Model
{
    protected $guarded = [];

    protected $dates = [
        'last_sent_at',
    ];
}
