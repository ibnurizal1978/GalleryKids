<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\KcaeSpacesCategory
 *
 * @property int $id
 * @property string $name
 * @property int $serial
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\KcaeSpace[] $spaces
 * @property-read int|null $spaces_count
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpacesCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpacesCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpacesCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpacesCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpacesCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpacesCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpacesCategory whereSerial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpacesCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpacesCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class KcaeSpacesCategory extends Model
{
    protected $guarded = [];

    public function spaces()
    {
        return $this->hasMany( KcaeSpace::class, 'category_id' );
    }
}
