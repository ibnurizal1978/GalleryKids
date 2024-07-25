<?php

namespace App\Models;

use App\KcaeSpaceSlide;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Archive\Entities\Archive;
use Modules\Reaction\Entities\Reaction;


/**
 * App\Models\KcaeSpace
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $image
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\KcaeSpacesCategory|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpace newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpace query()
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpace whereCategoryId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpace whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpace whereDescription( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpace whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpace whereImage( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpace whereName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|KcaeSpace whereUpdatedAt( $value )
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|KcaeSpaceSlide[] $slides
 * @property-read int|null $slides_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Reaction[] $reactions
 * @property-read int|null $reactions_count
 */
class KcaeSpace extends Model
{
    // Note: Use 'public_uploads' disk.
    public const IMAGE_DIRECTORY = 'kcae/spaces/thumbnails/';

    protected $guarded = [];

    public function getImageAttribute( $image )
    {
        return url( '/uploads/' . self::IMAGE_DIRECTORY . $image );
    }

    public function slides()
    {
        return $this->hasMany( KcaeSpaceSlide::class, 'space_id' );
    }

    public function category()
    {
        return $this->belongsTo( KcaeSpacesCategory::class, 'category_id' );
    }

    public function reactions()
    {
        return $this->morphMany( Reaction::class, 'reactionable' );
    }

    public function archives_user()
    {
        return $this->morphMany( Archive::class, 'archivable' )
                    ->where( 'user_id', Auth::user()->id );
    }
}
