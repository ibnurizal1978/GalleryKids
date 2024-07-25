<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\KcaeHeroSlide
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $image
 * @property string|null $video
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeHeroSlide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeHeroSlide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeHeroSlide query()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeHeroSlide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeHeroSlide whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeHeroSlide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeHeroSlide whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeHeroSlide whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeHeroSlide whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeHeroSlide whereVideo($value)
 * @mixin \Eloquent
 */
class KcaeHeroSlide extends Model
{
    // Note: Use 'public_uploads' disk.
    public const IMAGE_DIRECTORY = 'kcae/hero/slides/';

    protected $guarded = [];

    public function getImageAttribute( $image )
    {
        return url( '/uploads/' . self::IMAGE_DIRECTORY . $image );
    }
}
