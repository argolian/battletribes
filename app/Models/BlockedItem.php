<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\BlockedItem
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedItem query()
 * @mixin \Eloquent
 * @property-read \App\Models\BlockedType $blockedType
 * @method static \Illuminate\Database\Query\Builder|BlockedItem onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|BlockedItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|BlockedItem withoutTrashed()
 * @property int $id
 * @property int $typeId
 * @property string $value
 * @property string|null $note
 * @property int|null $userId
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedItem whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedItem whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedItem whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlockedItem whereValue($value)
 */
class BlockedItem extends Model
{
    use SoftDeletes;

    protected $table;
    protected $connection;
    public    $timestamps = true;
    protected $guarded    = ['id'];
    protected $dates      = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable   = ['typeId', 'value', 'note', 'userId'];
    protected $casts      = ['typeId' => 'integer', 'value' => 'string', 'note' => 'string', 'userId' => 'integer'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('laravelblocker.blockerDatabaseConnection');
        $this->table      = config('laravelblocker.blockerDatabaseTable');
    }

    public function getConnectionName()
    {
        return $this->connection;
    }

    public function blockedType()
    {
        return $this->belongsTo(BlockedType::class, 'typeId');
    }

    public function getTableName()
    {
        return $this->table;
    }
}
