<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Profile
 *
 * @property int $id
 * @property int $user_id
 * @property int $theme_id
 * @property string|null $location
 * @property string|null $bio
 * @property string|null $twitter_username
 * @property string|null $github_username
 * @property string|null $avatar
 * @property int $avatar_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Profile newModelQuery()
 * @method static Builder|Profile newQuery()
 * @method static Builder|Profile query()
 * @method static Builder|Profile whereAvatar($value)
 * @method static Builder|Profile whereAvatarStatus($value)
 * @method static Builder|Profile whereBio($value)
 * @method static Builder|Profile whereCreatedAt($value)
 * @method static Builder|Profile whereGithubUsername($value)
 * @method static Builder|Profile whereId($value)
 * @method static Builder|Profile whereLocation($value)
 * @method static Builder|Profile whereThemeId($value)
 * @method static Builder|Profile whereTwitterUsername($value)
 * @method static Builder|Profile whereUpdatedAt($value)
 * @method static Builder|Profile whereUserId($value)
 * @mixin Eloquent
 * @property-read Theme|null $theme
 * @property-read User $user
 */
class Profile extends Model
{
    protected $table = 'profiles';
    protected $guarded = ['id'];
    protected $fillable = [
        'theme_id',
        'location',
        'bio',
        'twitter_username',
        'github_username',
        'user_profile_bg',
        'avatar',
        'avatar_status',
    ];
    protected $casts = [
        'theme_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function theme()
    {
        return $this->hasOne(Theme::class);
    }


}
