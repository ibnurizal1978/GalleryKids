<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


/**
 * App\Models\UserData
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $memberson_customer_number
 * @property string|null $memberson_member_number
 * @property string|null $accenture_user_id
 * @property string|null $profile_token
 * @property \Illuminate\Support\Carbon|null $profile_token_expires_at
 * @property bool $email_verified
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $membership_type
 * @property string|null $membership_tier
 * @property string|null $benefit_code
 * @property-read mixed $parent_benefit
 * @property-read mixed $post_login_screen
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserData query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereAccentureUserId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereBenefitCode( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereEmailVerified( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereMembershipTier( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereMembershipType( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereMembersonCustomerNumber( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereMembersonMemberNumber( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereProfileToken( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereProfileTokenExpiresAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereUserId( $value )
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $gpe_expires_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereGpeExpiresAt( $value )
 * @property string|null $gpe_benefit_id
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereGpeBenefitId( $value )
 */
class UserData extends Model
{
    protected $guarded = [];

    protected $casts = [
        'email_verified' => 'boolean'
    ];

    protected $dates = [
        'profile_token_expires_at',
        'gpe_expires_at',
    ];

    protected $visible = [
        'parent_benefit'
    ];

    public function getParentBenefitAttribute()
    {
        return in_array(
            $this->membership_type,
            config( 'membership.memberson.parent_benefit_types' )
        );
    }

    public function getPostLoginScreenAttribute()
    {
        if ( 'Gallery Explorer' === $this->membership_type ) {
            return 'GPE' !== $this->benefit_code ? 'GE' : false;
        }

        return $this->user->isGuardian() &&
               ! optional( $this->user->children )->count()
            ? 'GI'
            : false;
    }

    public function user()
    {
        return $this->belongsTo( User::class );
    }
}
