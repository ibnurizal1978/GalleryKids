<?php

namespace App;

use App\Models\KcaeSpace;
use Illuminate\Database\Eloquent\Model;

/**
 * App\KcaeSpaceSlide
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $image
 * @property int|null $space_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read KcaeSpace|null $space
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpaceSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpaceSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpaceSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpaceSlide whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpaceSlide whereDescription( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpaceSlide whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpaceSlide whereImage( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpaceSlide whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpaceSlide whereSpaceId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpaceSlide whereUpdatedAt( $value )
 * @mixin \Eloquent
 */
class KcaeSpaceSlide extends Model
{
    // Note: Use 'public_uploads' disk.
    public const IMAGE_DIRECTORY = 'kcae/spaces/slides/';

    protected $guarded = [];

    public function getImageAttribute( $image )
    {
        return url( '/uploads/' . self::IMAGE_DIRECTORY . $image );
    }

    public function space()
    {
        return $this->belongsTo( KcaeSpace::class, 'space_id' );
    }
}
