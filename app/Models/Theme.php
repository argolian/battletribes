<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Theme
 *
 * @property int $id
 * @property string $name
 * @property string $link
 * @property string|null $notes
 * @property int $status
 * @property string $taggable_type
 * @property int $taggable_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static Builder|Theme newModelQuery()
 * @method static Builder|Theme newQuery()
 * @method static Builder|Theme query()
 * @method static Builder|Theme whereCreatedAt($value)
 * @method static Builder|Theme whereDeletedAt($value)
 * @method static Builder|Theme whereId($value)
 * @method static Builder|Theme whereLink($value)
 * @method static Builder|Theme whereName($value)
 * @method static Builder|Theme whereNotes($value)
 * @method static Builder|Theme whereStatus($value)
 * @method static Builder|Theme whereTaggableId($value)
 * @method static Builder|Theme whereTaggableType($value)
 * @method static Builder|Theme whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Profile[] $profile
 * @property-read int|null $profile_count
 * @method static \Illuminate\Database\Query\Builder|Theme onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Theme withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Theme withoutTrashed()
 */
class Theme extends Model
{
    use SoftDeletes;
    const default = 1;

    protected $table = 'themes';

    public $timestamps = true;


    protected $guarded = [
        'id',
    ];

    protected $hidden = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

   protected $fillable = [
        'name',
        'link',
        'notes',
        'status',
        'taggable_id',
        'taggable_type',
    ];

    protected $casts = [
        'id'            => 'integer',
        'name'          => 'string',
        'link'          => 'string',
        'notes'         => 'string',
        'status'        => 'boolean',
        'activated'     => 'boolean',
        'taggable_id'   => 'integer',
        'taggable_type' => 'string',
    ];

   public static function rules($id = 0, $merge = [])
    {
        return array_merge(
            [
                'name'   => 'required|min:3|max:50|unique:themes,name'.($id ? ",$id" : ''),
                'link'   => 'required|min:3|max:255|unique:themes,link'.($id ? ",$id" : ''),
                'notes'  => 'max:500',
                'status' => 'required',
            ],
            $merge
        );
    }

    public function profile()
    {
        return $this->hasMany(Profile::class);
    }
}
