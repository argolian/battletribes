<?php

namespace App\Models;

use App\Traits\UserAgentDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Activity
 *
 * @property-read mixed $user_agent_details
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
 * @method static \Illuminate\Database\Query\Builder|Activity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
 * @method static \Illuminate\Database\Query\Builder|Activity withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Activity withoutTrashed()
 * @mixin \Eloquent
 */
class Activity extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection;

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'userType',
        'userId',
        'route',
        'ipAddress',
        'userAgent',
        'locale',
        'referer',
        'methodType',
    ];

    protected $casts = [
        'description'   => 'string',
        'user'          => 'integer',
        'route'         => 'string',
        'ipAddress'     => 'string',
        'userAgent'     => 'string',
        'locale'        => 'string',
        'referer'       => 'string',
        'methodType'    => 'string',
    ];

    /**
     * Create a new instance to set the table and connection.
     *
     * @return void
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('LaravelLogger.loggerDatabaseTable');
        $this->connection = config('LaravelLogger.loggerDatabaseConnection');
    }

    /**
     * Get the database connection.
     */
    public function getConnectionName()
    {
        return $this->connection;
    }

    /**
     * Get the database connection.
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * An activity has a user.
     *
     * @var array
     */
    public function user()
    {
        return $this->hasOne(config('LaravelLogger.defaultUserModel'));
    }

    /**
     * Get a validator for an incoming Request.
     *
     * @param array $merge (rules to optionally merge)
     *
     * @return array
     */
    public static function rules($merge = [])
    {
        if (app() instanceof \Illuminate\Foundation\Application) {
            $route_url_check = \Illuminate\Foundation\Application::VERSION < 5.8 ? 'active_url' : 'url';
        } else {
            $route_url_check = 'url';
        }

        return array_merge(
            [
                'description'   => 'required|string',
                'userType'      => 'required|string',
                'userId'        => 'nullable|integer',
                'route'         => 'nullable|'.$route_url_check,
                'ipAddress'     => 'nullable|ip',
                'userAgent'     => 'nullable|string',
                'locale'        => 'nullable|string',
                'referer'       => 'nullable|string',
                'methodType'    => 'nullable|string',
            ],
            $merge
        );
    }

    public function getUserAgentDetailsAttribute()
    {
        return UserAgentDetails::details($this->userAgent);
    }
}
