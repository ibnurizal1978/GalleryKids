<?php

namespace Modules\Create\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Reaction\Entities\Reaction;
use Modules\Archive\Entities\Archive;
use Illuminate\Database\Eloquent\Builder;
use Auth;

class Create extends Model
{
    protected $fillable = [
        'title',
        'synopsis',
        'url',
        'content_start_date',
        'content_expiry_date',
        'members_only',
        'category_id'
    ];

    public function age_groups()
    {
        return $this->morphToMany( 'Modules\AgeGroup\Entities\AgeGroup', 'age_groupable' );
    }

    public function category()
    {
        return $this->belongsTo( 'Modules\Category\Entities\Category' );
    }

    public function thumbnails()
    {
        return $this->hasMany( 'Modules\Create\Entities\Thumbnail' );
    }

    public function reactions()
    {
        return $this->morphMany( Reaction::class, 'reactionable' );
    }

    public function archives()
    {
        return $this->morphMany( Archive::class, 'archivable' );
    }

    public function archives_user()
    {
        return $this->morphMany( Archive::class, 'archivable' )->where( 'user_id', Auth::user()->id );
    }

    public function scopeEnable( $query )
    {
        return $query->where( 'status', 'Enable' );
    }

    public function scopeNonMembers( $query )
    {
        return $query->where( 'members_only', 'No' );
    }

    public function scopeAgeGroup( $query )
    {
//        $age = date('Y') - Auth::user()->year_of_birth;
        $age = optional( optional( Auth::user() )->dob )->age;

        switch ( $age ) {
            case ( $age < 7 ):
                $age_group = 'Less than 7 years old';
                break;
            case ( $age >= 7 && $age <= 10 ):
                $age_group = '7-10 years old';
                break;
            case ( $age >= 11 && $age <= 13 ):
                $age_group = '11-13 years old';
                break;
            case ( $age >= 14 && $age <= 15 ):
                $age_group = '14-15 years old';
                break;
            case ( $age > 15 ):
                $age_group = 'More than 15 years old';
                break;

        }

        return $query->whereHas( 'age_groups', function ( Builder $query ) use ( $age_group ) {
            $query->where( 'age_group', $age_group );
        } );

    }

    public function scopeValid( $query )
    {
        return $query->where( function ( $query ) {
            $query->where( function ( $query ) {
                $query->whereNull( 'content_start_date' )
                      ->orWhere( 'content_start_date', '<=', date( 'Y-m-d' ) );
            } )
                  ->where( function ( $query ) {
                      $query->whereNull( 'content_expiry_date' )
                            ->orWhere( 'content_expiry_date', '>=', date( 'Y-m-d' ) );
                  } );
        } );
    }

}
