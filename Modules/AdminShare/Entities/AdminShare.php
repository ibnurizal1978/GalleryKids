<?php

namespace Modules\AdminShare\Entities;

use App\Models\AdminShareDeriv;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\Reaction\Entities\Reaction;
use Modules\Archive\Entities\Archive;
use Auth;

class AdminShare extends Model
{
    const IMAGES_UPLOADS_FOLDER = 'nationalgallery/artworks/';
    protected $table = 'admin_share';
    protected $fillable = [
        'uid',
        'image',
        'TITLE',
        'category_id',
        'ARTIST',
        'DATE_OF_ART_CREATED',
        'CLASSIFICATION',
        'CREDITLINE',
        'status',
        'dimension',
        'medium',
        'data',
    ];

    protected $casts = [
        'data' => 'object'
    ];

    public function getImageAttribute( $value )
    {
//        return Storage::disk( get_publicly_accessible_disk() )
//                      ->url( self::IMAGES_UPLOADS_FOLDER . $this->uid . '/' . $value );

        return url( '/uploads/' . self::IMAGES_UPLOADS_FOLDER . $this->uid . '/' . $value );
    }

    public function getFullImageAttribute()
    {
        $largeDerive = $this->derivs()
                            ->orderByDesc( 'height' )
                            ->first();

        if ( ! $largeDerive || ! $largeDerive->image ) {
            return null;
        }

        return Storage::disk( get_publicly_accessible_disk() )
                      ->url( self::IMAGES_UPLOADS_FOLDER . $this->uid . '/' . $largeDerive->image );
    }

    public function oldUpdate( $data )
    {
        return $this->update( $data );
    }

    public function scopeEnable( $query )
    {
        return $query->where( 'status', 'Enable' );
    }

    public function reactions()
    {
        return $this->morphMany( Reaction::class, 'reactionable' );
    }

    public function archives_user()
    {
        return $this->morphMany( Archive::class, 'archivable' )->where( 'user_id', Auth::user()->id );
    }

    public function category()
    {
        return $this->belongsTo( 'Modules\Category\Entities\Category', 'category_id' );
    }

    public function derivs()
    {
        return $this->hasMany( AdminShareDeriv::class, 'share_id' );
    }


}
