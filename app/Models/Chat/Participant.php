<?php

namespace App\Models\Chat;

use App\Constants\ModelTable;
use App\Models\Account\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int|null $thread_id
 * @property int|null $user_id
 * @property Carbon|null $visited_at
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Message[] $messages
 * @property-read Thread $thread
 * @property-read User $user
 * @mixin Eloquent
 */
class Participant extends Model
{
    use SoftDeletes;

    protected $table = ModelTable::CHAT_PARTICIPANTS;

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
