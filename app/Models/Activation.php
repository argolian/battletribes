<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Activation
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $ip_address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Activation newModelQuery()
 * @method static Builder|Activation newQuery()
 * @method static Builder|Activation query()
 * @method static Builder|Activation whereCreatedAt($value)
 * @method static Builder|Activation whereId($value)
 * @method static Builder|Activation whereIpAddress($value)
 * @method static Builder|Activation whereToken($value)
 * @method static Builder|Activation whereUpdatedAt($value)
 * @method static Builder|Activation whereUserId($value)
 * @mixin Eloquent
 * @property-read \App\Models\User $user
 */
class Activation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activations';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
        'token',
        'ip_address',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
        'ip_address',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'user_id'       => 'integer',
        'token'         => 'string',
        'ip_address'    => 'string',
    ];

    /**
     * Get the user that owns the activation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
