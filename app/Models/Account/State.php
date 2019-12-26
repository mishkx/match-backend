<?php

namespace App\Models\Account;

use App\Base\Model;
use App\Constants\ModelTable;
use Carbon\Carbon;
use Eloquent;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static Builder|self whereRecentlyPresent()
 * @property int $id
 * @property int|null $user_id
 * @property string|null $session_id
 * @property string|null $ip_address
 * @property Point $location
 * @property boolean $is_accurate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @mixin Eloquent|SpatialTrait
 */
class State extends Model
{
    use SpatialTrait;

    protected $table = ModelTable::USER_STATES;

    protected $casts = [
        'is_accurate' => 'boolean',
    ];

    protected $spatialFields = [
        'location',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param self $query
     * @return mixed
     */
    public function scopeWhereRecentlyPresent($query)
    {
        return $query->where(
            'updated_at',
            '>=',
            Carbon::now()->subDays(config('options.match.userPresenceDays'))->toDateTimeString()
        );
    }
}
