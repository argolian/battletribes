<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Database
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Database newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Database newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Database query()
 * @mixin \Eloquent
 */
class Database extends Model
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
     * Create a new instance to set the table and connection.
     *
     * @return void
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        if ($connection = config('roles.connection')) {
            $this->connection = $connection;
        }
    }

    /**
     * Get the database connection.
     */
    public function getConnectionName()
    {
        return $this->connection;
    }

    /**
     * Get the database table.
     */
    public function getTableName()
    {
        return $this->table;
    }
}
