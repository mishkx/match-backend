<?php

namespace App\Models\Account;

use App\Base\Model;
use App\Constants\ModelTable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $provider
 * @property string|null $provider_user_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @mixin Eloquent
 */
class SocialAccount extends Model
{
    use SoftDeletes;

    protected $table = ModelTable::USER_SOCIAL_ACCOUNTS;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
