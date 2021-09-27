<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\User;

/**
 * App\Models\TwoStepAuth
 *
 * @method static Builder|TwoStepAuth newModelQuery()
 * @method static Builder|TwoStepAuth newQuery()
 * @method static Builder|TwoStepAuth query()
 * @mixin Eloquent
 * @property int $id
 * @property int $userId
 * @property string|null $authCode
 * @property int $authCount
 * @property bool $authStatus
 * @property Carbon|null $authDate
 * @property Carbon|null $requestDate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|TwoStepAuth whereAuthCode($value)
 * @method static Builder|TwoStepAuth whereAuthCount($value)
 * @method static Builder|TwoStepAuth whereAuthDate($value)
 * @method static Builder|TwoStepAuth whereAuthStatus($value)
 * @method static Builder|TwoStepAuth whereCreatedAt($value)
 * @method static Builder|TwoStepAuth whereId($value)
 * @method static Builder|TwoStepAuth whereRequestDate($value)
 * @method static Builder|TwoStepAuth whereUpdatedAt($value)
 * @method static Builder|TwoStepAuth whereUserId($value)
 * @property-read User|null $user
 */
class TwoStepAuth extends Model
{
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
        'requestDate',
        'authDate',
    ];

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'userId',
        'authCode',
        'authCount',
        'authStatus',
        'requestDate',
        'authDate',
    ];

    protected $casts = [
        'userId'     => 'integer',
        'authCode'   => 'string',
        'authCount'  => 'integer',
        'authStatus' => 'boolean',
    ];

    /**
     * Create a new instance to set the table and connection.
     *
     * @return void
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('laravel2step.laravel2stepDatabaseTable');
        $this->connection = config('laravel2step.laravel2stepDatabaseConnection');
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

   public function user()
    {
        return $this->hasOne(config('laravel2step.defaultUserModel'));
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
        return array_merge(
            [
                'userId'     => 'required|integer',
                'authCode'   => 'required|string|max:4|min:4',
                'authCount'  => 'required|integer',
                'authStatus' => 'required|boolean',
            ],
            $merge
        );
    }
}
