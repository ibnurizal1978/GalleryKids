<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminShare\Entities\AdminShare;

/**
 * App\Models\AdminShareDeriv
 *
 * @property int $id
 * @property int $share_id
 * @property int|null $uid
 * @property int|null $order
 * @property string $image
 * @property int|null $width
 * @property int|null $height
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read AdminShare $admin_share
 * @method static \Illuminate\Database\Eloquent\Builder|AdminShareDeriv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminShareDeriv newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminShareDeriv query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminShareDeriv whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminShareDeriv whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminShareDeriv whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminShareDeriv whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminShareDeriv whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminShareDeriv whereShareId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminShareDeriv whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminShareDeriv whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminShareDeriv whereWidth($value)
 * @mixin \Eloquent
 */
class AdminShareDeriv extends Model
{
    protected $guarded = [];

    public function admin_share()
    {
        return $this->belongsTo( AdminShare::class, 'share_id' );
    }
}
