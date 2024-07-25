<?php

namespace App;

use App\Models\MembersonProfile;
use App\Models\UserData;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Reaction\Entities\Reaction;

/**
 * App\User
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $username
 * @property string|null $designation
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string $status
 * @property string|null $otp
 * @property string|null $school
 * @property string|null $level
 * @property string|null $class
 * @property string|null $team
 * @property int $role_id
 * @property string|null $remember_token
 * @property int|null $currentLevel
 * @property int|null $visit
 * @property string|null $date
 * @property string|null $notification
 * @property int|null $subscribe
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $sub
 * @property string|null $ref_number
 * @property string|null $ic
 * @property \Illuminate\Support\Carbon|null $dob
 * @property string|null $gender
 * @property string|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $children
 * @property-read int|null $children_count
 * @property-read UserData|null $data
 * @property-read mixed $is_student
 * @property-read \App\Import|null $import
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $parents
 * @property-read int|null $parents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Question\Entities\Question[] $questions
 * @property-read int|null $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Reaction[] $reactions
 * @property-read int|null $reactions_count
 * @property-read \App\Role $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\Share\Entities\Share[] $shares
 * @property-read int|null $shares_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereClass( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountry( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentLevel( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDate( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDesignation( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDob( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIc( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImage( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLevel( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNotification( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOtp( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRefNumber( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSchool( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSub( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSubscribe( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTeam( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVisit( $value )
 * @mixin \Eloquent
 * @property string|null $mobile
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile( $value )
 * @property-read MembersonProfile|null $membersonProfile
 * @property string|null $guid
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGuid($value)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'guid',
        'email',
        'username',
        'subscribe',
        'notification',
        'date',
        'visit',
        'designation',
        'image',
        'email_verified_at',
        'password',
        'hash',
        'status',
        'otp',
        'currentLevel',
        'school',
        'level',
        'class',
        'team',
        'role_id',
        'subscribe',
        'sub',
        'ref_number',
        'ic',
        'dob',
        'gender',
        'country',
        'mobile',
    ];

    protected $dates = [
        'dob'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $visible = [ 'is_student' ];

    public function getIsStudentAttribute()
    {
        return (bool) $this->role->name == 'student';
    }

    public function role()
    {
        return $this->belongsTo( 'App\Role' );
    }

    public function children()
    {
        return $this->belongsToMany( 'App\User', 'relation_user', 'parent_id', 'child_id' );
    }


    public function parents()
    {
        return $this->belongsToMany( 'App\User', 'relation_user', 'child_id', 'parent_id' );
    }

    public function reactions()
    {
        return $this->hasMany( 'Modules\Reaction\Entities\Reaction' )->with( [ 'reactionable' ] );
    }

    public function shares()
    {
        return $this->hasMany( 'Modules\Share\Entities\Share' );
    }

    public function questions()
    {
        return $this->hasMany( 'Modules\Question\Entities\Question' );
    }

    public function import()
    {
        return $this->hasOne( 'App\Import' );
    }

    public function data()
    {
        return $this->hasOne( UserData::class );
    }

    public function isAdmin()
    {
        if ( $this->role->name == 'admin' ) {
            return true;
        }

        return false;
    }

    public function isStudent()
    {
        if ( $this->role->name == 'student' ) {
            return true;
        }

        return false;
    }

    public function isGuardian()
    {
        if ( $this->role->name == 'guardian' ) {
            return true;
        }

        return false;
    }

    public function isTeacher()
    {
        if ( $this->role->name == 'teacher' ) {
            return true;
        }

        return false;
    }

    public function membersonProfile()
    {
        return $this->hasOne( MembersonProfile::class );
    }
}
