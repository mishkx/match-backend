<?php

namespace App\Models\Account;

use App\Base\Model;
use App\Constants\ModelTable;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $subject_id
 * @property int|null $object_id
 * @property boolean $is_liked
 * @property Carbon|null $marked_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $object
 * @property-read User $subject
 * @mixin Eloquent
 */
class Match extends Model
{
    protected $table = ModelTable::USER_MATCHES;

    protected $casts = [
        'is_liked' => 'boolean',
        'marked_at' => 'datetime',
    ];

    public function object(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
