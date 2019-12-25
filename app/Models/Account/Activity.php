<?php

namespace App\Models\Account;

use App\Base\Model;
use App\Constants\ModelTable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $session_id
 * @property string|null $ip_address
 * @property float|null $latitude
 * @property float|null $longitude
 * @property boolean $is_accurate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @mixin Eloquent
 */
class Activity extends Model
{
    protected $table = ModelTable::USER_ACTIVITIES;

    protected $casts = [
        'is_accurate' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
