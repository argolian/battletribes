<?php

namespace App\Models;

use App\Traits\HasRoleAndPermission;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Team|null $currentTeam
 * @property-read string $profile_photo_url
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Team[] $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read Collection|Team[] $teams
 * @property-read int|null $teams_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereCurrentTeamId($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereProfilePhotoPath($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static Builder|User whereTwoFactorSecret($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string|null $first_name
 * @property string|null $last_name
 * @property int $activated
 * @property string $token
 * @property string|null $signup_ip_address
 * @property string|null $signup_confirmation_ip_address
 * @property string|null $signup_sm_ip_address
 * @property string|null $admin_ip_address
 * @property string|null $updated_ip_address
 * @property string|null $deleted_ip_address
 * @property string|null $deleted_at
 * @method static Builder|User whereActivated($value)
 * @method static Builder|User whereAdminIpAddress($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereDeletedIpAddress($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereSignupConfirmationIpAddress($value)
 * @method static Builder|User whereSignupIpAddress($value)
 * @method static Builder|User whereSignupSmIpAddress($value)
 * @method static Builder|User whereToken($value)
 * @method static Builder|User whereUpdatedIpAddress($value)
 * @property-read \App\Models\Profile|null $profile
 * @property-read Collection|\App\Models\Profile[] $profiles
 * @property-read int|null $profiles_count
 * @property-read Collection|\App\Models\Social[] $social
 * @property-read int|null $social_count
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @property-read Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read Collection|\App\Models\Permission[] $userPermissions
 * @property-read int|null $user_permissions_count
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    use HasRoleAndPermission;

    protected $table = 'users';
    public $timestamps = true;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'activated',
        'token',
        'signup_ip_address',
        'signup_confirmation_ip_address',
        'signup_sm_ip_address',
        'admin_ip_address',
        'updated_ip_address',
        'deleted_ip_address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'activated',
        'token'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id'                                => 'integer',
        'first_name'                        => 'string',
        'last_name'                         => 'string',
        'email'                             => 'string',
        'password'                          => 'string',
        'activated'                         => 'boolean',
        'token'                             => 'string',
        'signup_ip_address'                 => 'string',
        'signup_confirmation_ip_address'    => 'string',
        'signup_sm_ip_address'              => 'string',
        'admin_ip_address'                  => 'string',
        'updated_ip_address'                => 'string',
        'deleted_ip_address'                => 'string',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function social()
    {
        return $this->hasMany(Social::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class)->withTimestamps();
    }

    public function hasProfile($name)
    {
        foreach($this->profiles as $profile)
        {
            if($profile->name === $name) return true;
        }
        return false;
    }

    public function assignProfile(Profile $profile)
    {
        return $this->profiles()->attach($profile);
    }

    public function removeProfile(Profile $profile)
    {
        return $this->profiles()->detach($profile);
    }


}
