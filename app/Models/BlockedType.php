<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\BlockedType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BlockedItem[] $blockedItems
 * @property-read int|null $blocked_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedType newQuery()
 * @method static \Illuminate\Database\Query\Builder|BlockedType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedType query()
 * @method static \Illuminate\Database\Query\Builder|BlockedType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|BlockedType withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedType whereUpdatedAt($value)
 */
class BlockedType extends Model
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
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
    ];

    protected $casts = [
        'slug' => 'string',
        'name' => 'string',
    ];

    /**
     * Create a new instance to set the table and connection.
     *
     * @return void
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('laravelblocker.blockerDatabaseConnection');
        $this->table = config('laravelblocker.blockerTypeDatabaseTable');
    }

    /**
     * Get the database connection.
     */
    public function getConnectionName()
    {
        return $this->connection;
    }

    public function getTableName()
    {
        return $this->table;
    }

    public function blockedItems()
    {
        return $this->hasMany(BlockedItem::class);
    }
}
